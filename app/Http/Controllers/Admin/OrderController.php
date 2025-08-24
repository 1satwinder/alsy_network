<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\OrderListBuilder;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatusLog;
use App\Models\State;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Sentry;
use Throwable;

class OrderController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return OrderListBuilder::render();
    }

    public function details(Order $order): RedirectResponse|Renderable
    {
        $productDetails = $order->products()
            ->with('product.media', 'member.user')->get();

        return view('admin.order.detail', [
            'productDetails' => $productDetails,
            'orderStatus' => Order::STATUSES,
            'order' => $order,
            'orderLogs' => OrderStatusLog::where('order_product_id', $productDetails->pluck('id')->first())->get(),
            'state' => State::get(),
        ]);
    }

    public function statusUpdate(Request $request, Order $order): RedirectResponse
    {
        try {
            if ($request->get('status') == Order::STATUS_DISPATCH) {
                if (! $order->hasCourierDetails()) {
                    return redirect()->back()->with('error', 'Courier Partner, AWB & Tracking URL is required before dispatching an Order')->withInput();
                }
            }

            return DB::transaction(function () use ($request, $order) {
                $order->products()->update([
                    'status' => $request->get('status'),
                ]);
                $order->status = $request->get('status');
                $order->save();

                foreach ($order->products as $orderProduct) {
                    OrderStatusLog::create([
                        'order_product_id' => $orderProduct->id,
                        'order_id' => $orderProduct->order_id,
                        'remarks' => $request->get('remarks'),
                        'status' => $request->get('status'),
                    ]);
                }

                if ($request->get('status') == Order::STATUS_DELIVER) {
                    // SendOrderDeliveredSMS::dispatch($order);
                }

                if ($request->get('status') == Order::STATUS_DISPATCH) {
                    //SendOrderDispatchedSMS::dispatch($order);
                }

                return redirect()
                    ->route('admin.orders.details', $order)
                    ->with('success', 'Product Order Status Updated successfully');
            });
        } catch (Throwable $e) {
            Sentry::captureException($e);

            return redirect()->back()->with('error', 'Something went wrong. Please try again')->withInput();
        }
    }

    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function OrderStatusUpdate(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'status' => 'required|in:'.implode(',', array_keys(Order::STATUSES)),
            'remarks' => 'required',
        ]);

        if ($request->get('status')) {
            if (count($request->get('orders')) > 0) {
                /** @var Collection $orders */
                $orders = Order::whereIn('id', $request->get('orders'))
                    ->get();

                if ($request->get('status') == Order::STATUS_DISPATCH &&
                    $orders->countBy(function (Order $order) {
                        return ! $order->hasCourierDetails();
                    })
                ) {
                    return redirect()->back()->with('error', 'Every Order should have Courier Partner, AWB & Tracking URL filled for bulk dispatch')->withInput();
                }

                DB::transaction(function () use ($request) {
                    Order::whereIn('id', $request->get('orders'))
                        ->update(['status' => $request->get('status')]);

                    OrderProduct::whereIn('order_id', $request->get('orders'))->update([
                        'status' => $request->get('status'),
                    ]);

                    Order::whereIn('id', $request->get('orders'))->eachById(function (Order $order) use ($request) {
                        foreach ($order->products as $orderProduct) {
                            OrderStatusLog::create([
                                'order_product_id' => $orderProduct->id,
                                'order_id' => $orderProduct->order_id,
                                'remarks' => $request->get('remarks'),
                                'status' => $request->get('status'),
                            ]);
                        }
                    });
                });

                if ($request->get('status') == Order::STATUS_DISPATCH) {
                    $orders->each(function (Order $order) {
                        //SendOrderDispatchedSMS::dispatch($order);
                    });
                }

                return redirect()->back()->with(['success' => 'Order status changed successfully']);
            }

            return redirect()->back()->with(['error' => 'Please select Orders']);
        }

        return redirect()->back()->with(['error' => 'Please select status']);
    }

    /*
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function addressUpdate(Request $request, Order $order): RedirectResponse
    {
        $orderId = $order->id;

        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required|numeric',
            'state_id' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city_id' => 'required',
            'pincode' => 'required',
        ]);

        if ($order->isAddressEditable() === false) {
            return redirect()->back()->with('error', 'This address is no longer editable')->withInput();
        }

        try {
            return DB::transaction(function () use ($request, $orderId) {
                $updateAddress = ShippingAddress::where('order_id', $orderId)
                    ->update([
                        'name' => $request->get('name'),
                        'mobile' => $request->get('mobile'),
                        'address_line_1' => $request->get('address_line_1'),
                        'address_line_2' => $request->get('address_line_2'),
                        'pincode' => $request->get('pincode'),
                        'state_id' => $request->get('state_id'),
                        'city_id' => $request->get('city_id'),
                    ]);

                return redirect()
                    ->route('admin.orders.details', $orderId)
                    ->with('success', 'Order Address Updated successfully');
            });
        } catch (Throwable $e) {
            Sentry::captureException($e);

            return redirect()->back()->with('error', 'Something went wrong. Please try again')->withInput();
        }
    }

    public function editTransactionId(Order $order): RedirectResponse|Renderable
    {
        return view('admin.order.edit-transaction', [
            'order' => $order,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function updateTransactionId(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'transaction_id' => 'required',
        ]);

        if ($order = Order::where('order_no', $request->get('order_id'))
            ->whereNull('transaction_id')
            ->first()
        ) {
            $order->update([
                'transaction_id' => $request->get('transaction_id'),
            ]);

            return redirect()->route('admin.orders.index')->with('success', 'Payment Gateway Reference Updated successfully');
        }

        return redirect()->back()->with('error', 'Order is either invalid or Payment Gateway Reference is already set')->withInput();
    }
}
