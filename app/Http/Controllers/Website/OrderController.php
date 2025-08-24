<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CompanyStockLedger;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\State;
use App\Models\WalletTransaction;
use Auth;
use DB;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Log;
use Ramsey\Uuid\Uuid;
use Throwable;

class OrderController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse|Renderable
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|regex:/^[6789][0-9]{9}$/',
            'email' => 'nullable|email:rfc,dns',
            'address' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'pincode' => 'required|digits:6',
            'pay_by' => 'required|in:'.implode(',', array_keys(Order::PAY_BY_STATUSES)),
        ], [
            'phone.required' => 'The mobile number is required',
            'phone.regex' => 'The Mobile Number format is invalid',
        ]);

        $this->validate($request, [
            'financial_password' => 'required',
        ], [
            'financial_password.required' => 'The transaction password is required',
        ]);

        if (! Hash::check($request->get('financial_password'), $this->member->user->financial_password)) {
            return redirect()->back()->with('error', 'Invalid Transaction Password.')->withInput();
        }
        $member = $this->member;

        if ($member->isBlocked()) {
            return redirect()->back()->with(['error' => 'Member ID is blocked'])->withInput();
        }

        if (! $cart = Cart::where('member_id', $member->id)->first()) {
            return redirect()->back()->with(['success' => 'Cart is empty'])->withInput();
        }
        $cartItems = json_decode($cart->details, true);
        $cartTotal = 0;
        $productCount = 0;
        foreach ($cartItems as $productCart) {
            if ($product = Product::find($productCart['product_id'])) {
                $quantity = $productCart['selected_qty'];
                $total = $product->dp * $quantity;
                $cartTotal += $total;
                $productCount++;
                if ($product->company_stock < $quantity) {
                    return redirect()->back()->with([
                        'error' => $product->name.' Product cannot checkout because only '.round($product->company_stock).' product available .Please decreases product quantity',
                    ])->withInput();
                }
            }
        }

        if ($productCount == 0) {
            return redirect()->back()->with(['success' => 'Cart is empty'])->withInput();
        }

        if ($request->pay_by == Order::PAY_BY_WALLET
            &&
            $cartTotal > $this->member->wallet_balance
        ) {
            return redirect()->back()->with(['error' => 'you dont have enough wallet for purchase product'])->withInput();
        }
        try {
            return DB::transaction(function () use ($cartItems, $member, $request) {
                $order = Order::create([
                    'member_id' => $member->id,
                    'name' => $request->get('name'),
                    'phone' => $request->get('phone'),
                    'email' => $request->get('email'),
                    'address' => $request->get('address'),
                    'pincode' => $request->get('pincode'),
                    'state_id' => $request->get('state_id'),
                    'city_id' => $request->get('city_id'),
                    'transaction_id' => $request->get('transaction_id'),
                    'pay_by' => $request->get('pay_by'),
                    'order_no' => Uuid::uuid4(),
                    'admin_address' => settings('address_line_1').' '.settings('address_line_1'),
                    'admin_city' => settings('city?->name'),
                    'admin_state' => settings('state?->name'),
                    'admin_pincode' => settings('pincode'),
                    'admin_mobile' => settings('mobile'),
                    'admin_email' => settings('email'),
                    'status' => Order::STATUS_IN_CHECKOUT,
                    //'deliver_status' => Order::DELIVER_PENDING,
                    'payment_status' => Order::PAYMENT_IN_CHECKOUT,
                ]);

                $stateFlag = false;
                if ($order->state == settings('state')) {
                    $stateFlag = true;
                }
                $totalItems = 0;
                $totalInvoiceBv = 0;
                $totalQuantity = 0;
                $totalMRP = 0;
                $totalDP = 0;
                $totalTaxableValue = 0;
                $totalDiscount = 0;
                $totalSgstAmount = 0;
                $totalCgstAmount = 0;
                $totalIgstAmount = 0;
                $totalGstAmount = 0;
                $total = 0;
                $gstDetails = collect();
                $gstDetailSlabs = collect();

                $sgstPercentage = 0;
                $cgstPercentage = 0;
                $igstPercentage = 0;
                $sgstAmount = 0;
                $cgstAmount = 0;
                $igstAmount = 0;
                $cart = Cart::where('member_id', $member->id)->first();
                $cartItems = json_decode($cart->details, true);

                foreach ($cartItems as $productCart) {
                    if ($product = Product::with('GSTType')->find($productCart['product_id'])) {
                        $quantity = $productCart['selected_qty'];
                        $mrp = $product->mrp;
                        $dp = $product->dp;
                        $amount = $dp * $quantity;
                        $bv = $product->bv;
                        $totalBv = $bv * $quantity;
                        $category = Category::find($product->category_id);
                        $product = Product::with('GSTType')->find($productCart['product_id']);

                        if ($stateFlag) {
                            $sgstPercentage = $product->GSTType->sgst;
                            $cgstPercentage = $product->GSTType->cgst;
                            $gstPercentage = $sgstPercentage + $cgstPercentage;
                            $taxableValue = $amount * 100 / (100 + ($sgstPercentage + $cgstPercentage));
                            $sgstAmount = $taxableValue * $sgstPercentage / 100;
                            $cgstAmount = $taxableValue * $cgstPercentage / 100;
                            $gstAmount = $sgstAmount + $cgstAmount;
                        } else {
                            $igstPercentage = $product->GSTType->sgst + $product->GSTType->cgst;
                            $gstPercentage = $igstPercentage;
                            $taxableValue = $amount * 100 / (100 + $gstPercentage);
                            $igstAmount = $taxableValue * $igstPercentage / 100;
                            $gstAmount = $igstAmount;
                        }

                        $order->products()->create([
                            'order_id' => $order->id,
                            'member_id' => $order->member_id,
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'hsn_code' => $product->GSTType->hsn_code,
                            'sku' => $product->sku,
                            'category_name' => $category->name,
                            'mrp' => $product->mrp,
                            'dp' => $product->dp,
                            'bv' => $product->bv,
                            'total_mrp' => $product->mrp * $productCart['selected_qty'],
                            'total_dp' => $product->dp * $productCart['selected_qty'],
                            'total_bv' => $product->bv * $productCart['selected_qty'],
                            'taxable_value' => $taxableValue,
                            'discount' => 0,
                            'sgst_percentage' => $sgstPercentage,
                            'cgst_percentage' => $cgstPercentage,
                            'igst_percentage' => $igstPercentage,
                            'gst_percentage' => $gstPercentage,
                            'sgst_amount' => $sgstAmount,
                            'cgst_amount' => $cgstAmount,
                            'igst_amount' => $igstAmount,
                            'gst_amount' => $gstAmount,
                            'amount' => $amount,
                            'quantity' => $productCart['selected_qty'],
                            'total' => $amount * $productCart['selected_qty'],
                            'status' => OrderProduct::STATUS_IN_CHECKOUT,
                        ]);

                        $totalItems += 1;
                        $totalQuantity += $quantity;
                        $totalInvoiceBv += $totalBv;
                        $totalMRP += $product->mrp * $quantity;
                        $totalDP += $dp * $quantity;
                        $totalTaxableValue += $taxableValue;
                        $totalDiscount += $product->mrp * $quantity - $product->dp * $quantity;
                        $totalSgstAmount += $sgstAmount;
                        $totalCgstAmount += $cgstAmount;
                        $totalIgstAmount += $igstAmount;
                        $totalGstAmount += $gstAmount;
                        $total += $amount;

                        if ($gstDetailSlab = $gstDetailSlabs->get((string) $gstPercentage)) {
                            $gstDetailSlabs->put((string) $gstPercentage, [
                                'class' => $gstDetailSlab['class'],
                                'total' => $gstDetailSlab['total'] += $taxableValue,
                                'scheme' => $gstDetailSlab['scheme'],
                                'discount' => $gstDetailSlab['discount'] += $totalDiscount,
                                'sgst' => $gstDetailSlab['sgst'] + $sgstAmount,
                                'cgst' => $gstDetailSlab['cgst'] + $cgstAmount,
                                'igst' => $gstDetailSlab['igst'] + $igstAmount,
                                'gst' => $gstDetailSlab['gst'] + $gstAmount,
                            ]);
                        } else {
                            $gstDetailSlabs->put((string) $gstPercentage, [
                                'class' => "GST $gstPercentage%",
                                'total' => $taxableValue,
                                'scheme' => 0,
                                'discount' => $totalDiscount,
                                'sgst' => $sgstAmount,
                                'cgst' => $cgstAmount,
                                'igst' => $igstAmount,
                                'gst' => $gstAmount,
                            ]);
                        }
                        $gstDetails->put('total', $gstDetails->get('total') + $taxableValue);
                        $gstDetails->put('scheme', $gstDetails->get('scheme') + 0);
                        $gstDetails->put('discount', $gstDetails->get('discount') + $totalDiscount);
                        $gstDetails->put('sgst', $gstDetails->get('sgst') + $sgstAmount);
                        $gstDetails->put('cgst', $gstDetails->get('cgst') + $cgstAmount);
                        $gstDetails->put('igst', $gstDetails->get('igst') + $igstAmount);
                        $gstDetails->put('gst', $gstDetails->get('gst') + $gstAmount);
                    }
                }

                $gstDetails->put('slabs', $gstDetailSlabs->values());
                $order->total_items = $totalItems;
                $order->total_quantity = $totalQuantity;
                $order->total_mrp += $totalMRP;
                $order->total_dp += $totalDP;
                $order->total_bv += $totalInvoiceBv;
                $order->total_taxable_value += $totalTaxableValue;
                $order->total_discount += $totalDiscount;
                $order->total_sgst_amount += $totalSgstAmount;
                $order->total_cgst_amount += $totalCgstAmount;
                $order->total_igst_amount += $totalIgstAmount;
                $order->total_gst_amount += $totalGstAmount;
                $order->total = $total;
                $order->gst_details = $gstDetails;
                $order->payment_status = Order::PAYMENT_IN_CHECKOUT;
                $order->save();

                if ($order->pay_by == Order::PAY_BY_WALLET) {
                    foreach ($order->products()->with('product')->get() as $orderProduct) {
                        $orderProduct->product->decrement('company_stock', $orderProduct->quantity);
                        $orderProduct->product->companyStockLedger()->create([
                            'product_id' => $orderProduct->product_id,
                            'type' => CompanyStockLedger::TYPE_OUTWARD,
                            'quantity' => $orderProduct->quantity,
                            'amount' => $orderProduct->amount,
                        ]);
                    }
                    $order->member->walletTransactions()->create([
                        'member_id' => $order->member->id,
                        'opening_balance' => $member->wallet_balance,
                        'closing_balance' => $member->wallet_balance - $order->total,
                        'amount' => $order->total,
                        'tds' => 0,
                        'admin_charge' => 0,
                        'total' => $order->total,
                        'comment' => 'Product Purchase',
                        'type' => WalletTransaction::TYPE_DEBIT,
                    ]);

                    $order->invoice_no = $order->getUniqueInvoiceNo();
                    //$order->deliver_status = Order::DELIVER_PENDING;
                    $order->payment_status = Order::PAYMENT_CAPTURE;
                    $order->save();

                    Cart::whereMemberId($order->member_id)->update(['details' => null]);

                    return redirect()->route('website.orders.thanks', ['order' => $order])->with('success', 'Product Purchased successfully.');
                }
                if ($request->get('pay_by') == Order::PAY_BY_ONLINE) {
                    $details = Cart::getDetail($order->member);
                    $cartProducts = [];
                    if ($details) {
                        if (count($details->products) > 0) {
                            $cartProducts = $details->products;
                        }
                    }

                    return view('website.'.settings('front_template').'.website.cart.index', [
                        'paymentGatWay' => true,
                        'order' => $order,
                        'states' => State::get(),
                        'cartProducts' => $cartProducts,
                        'cartTotal' => $order->total,
                        'cartDetail' => $details,
                        'member' => Auth::user()->member,
                        'lastOrder' => null,
                    ]);
                }
            });

        } catch (Throwable $e) {
            Log::debug($e->getMessage(), $e->getTrace());

            return redirect()->back()->withInput()->with('error', 'Your Cart is Empty.')->withInput();
        }
    }

    public function thanks(Order $order): View|Factory|RedirectResponse|Application
    {
        if ($order->member_id != Auth::user()->member->id) {
            return redirect()->route('member.dashboard.index');
        }

        return view('website.'.settings('front_template').'.website.cart.thanks', [
            'order' => $order,
        ]);
    }
}
