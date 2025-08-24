<?php

namespace App\Models;

use App\Jobs\SendOrderPlacedSMS;
use App\Presenters\OrdersPresenter;
use App\Traits\CreationDateRangeScopes;
use DB;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $member_id
 * @property int|null $state_id
 * @property int|null $city_id
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property string $address
 * @property int $pincode
 * @property string|null $order_no
 * @property string|null $transaction_id
 * @property string|null $invoice_no
 * @property int $total_items
 * @property int $total_quantity
 * @property string|null $total_mrp
 * @property string|null $total_bv
 * @property string|null $total_dp
 * @property string $total_taxable_value
 * @property string $total_discount
 * @property string|null $total_sgst_amount
 * @property string|null $total_cgst_amount
 * @property string|null $total_igst_amount
 * @property string $total_gst_amount
 * @property string $amount
 * @property string $cart_amount
 * @property string $wallet
 * @property string $total
 * @property string $shipping_charge
 * @property string|null $gst_details
 * @property string|null $comment
 * @property string|null $courier_partner
 * @property string|null $courier_awb
 * @property string|null $courier_tracking_url
 * @property int $type 1: Customer
 * @property int $pay_by 1: Online, 2: COD, 3: Wallet
 * @property int $status
 * @property int $payment_status 1: In-Checkout, 2: Capture, 3: Authorized, 4: Fail
 * @property string|null $admin_address
 * @property string|null $admin_city
 * @property string|null $admin_state
 * @property string|null $admin_pincode
 * @property string|null $admin_mobile
 * @property string|null $admin_email
 * @property int $is_income_given
 * @property string|null $response
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\City|null $city
 * @property-read array $order_status
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Member $member
 * @property-read Collection<int, \App\Models\OrderProduct> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\State|null $state
 * @method static Builder|Order createdAtFrom(string $date)
 * @method static Builder|Order createdAtTo(string $date)
 * @method static Builder|Order customerOrder()
 * @method static Builder|Order maxBv($max)
 * @method static Builder|Order maxShippingCharge($max)
 * @method static Builder|Order maxTotal($max)
 * @method static Builder|Order maxTotalDp($max)
 * @method static Builder|Order maxTotalGstAmount($max)
 * @method static Builder|Order maxTotalItems($max)
 * @method static Builder|Order maxTotalMrp($max)
 * @method static Builder|Order maxTotalTaxableAmount($max)
 * @method static Builder|Order minBv($min)
 * @method static Builder|Order minShippingCharge($min)
 * @method static Builder|Order minTotal($min)
 * @method static Builder|Order minTotalDp($min)
 * @method static Builder|Order minTotalGstAmount($min)
 * @method static Builder|Order minTotalItems($min)
 * @method static Builder|Order minTotalMrp($min)
 * @method static Builder|Order minTotalTaxableAmount($min)
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order paymentCaptured()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddress($value)
 * @method static Builder|Order whereAdminAddress($value)
 * @method static Builder|Order whereAdminCity($value)
 * @method static Builder|Order whereAdminEmail($value)
 * @method static Builder|Order whereAdminMobile($value)
 * @method static Builder|Order whereAdminPincode($value)
 * @method static Builder|Order whereAdminState($value)
 * @method static Builder|Order whereAmount($value)
 * @method static Builder|Order whereCartAmount($value)
 * @method static Builder|Order whereCityId($value)
 * @method static Builder|Order whereComment($value)
 * @method static Builder|Order whereCourierAwb($value)
 * @method static Builder|Order whereCourierPartner($value)
 * @method static Builder|Order whereCourierTrackingUrl($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereEmail($value)
 * @method static Builder|Order whereGstDetails($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereInvoiceNo($value)
 * @method static Builder|Order whereIsIncomeGiven($value)
 * @method static Builder|Order whereMemberId($value)
 * @method static Builder|Order whereName($value)
 * @method static Builder|Order whereOrderNo($value)
 * @method static Builder|Order wherePayBy($value)
 * @method static Builder|Order wherePaymentStatus($value)
 * @method static Builder|Order wherePhone($value)
 * @method static Builder|Order wherePincode($value)
 * @method static Builder|Order whereResponse($value)
 * @method static Builder|Order whereShippingCharge($value)
 * @method static Builder|Order whereStateId($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereTotal($value)
 * @method static Builder|Order whereTotalBv($value)
 * @method static Builder|Order whereTotalCgstAmount($value)
 * @method static Builder|Order whereTotalDiscount($value)
 * @method static Builder|Order whereTotalDp($value)
 * @method static Builder|Order whereTotalGstAmount($value)
 * @method static Builder|Order whereTotalIgstAmount($value)
 * @method static Builder|Order whereTotalItems($value)
 * @method static Builder|Order whereTotalMrp($value)
 * @method static Builder|Order whereTotalQuantity($value)
 * @method static Builder|Order whereTotalSgstAmount($value)
 * @method static Builder|Order whereTotalTaxableValue($value)
 * @method static Builder|Order whereTransactionId($value)
 * @method static Builder|Order whereType($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereWallet($value)
 * @mixin Eloquent
 */
class Order extends Model implements HasMedia
{
    use CreationDateRangeScopes;
    use HasFactory;
    use InteractsWithMedia;
    use PresentableTrait;

    const PAY_BY_ONLINE = 1;

    const PAY_BY_COD = 2;

    const PAY_BY_WALLET = 3;

    const PAY_BY_CASH = 4;

    const PAY_BY_STATUSES = [
        self::PAY_BY_ONLINE => 'Online',
        self::PAY_BY_COD => 'COD',
        self::PAY_BY_WALLET => 'Wallet',
        self::PAY_BY_CASH => 'Cash',
    ];

    const PAYMENT_IN_CHECKOUT = 1;

    const PAYMENT_CAPTURE = 2;

    const PAYMENT_AUTHORISE = 3;

    const PAYMENT_FAIL = 4;

    const PAYMENT_STATUSES = [
        self::PAYMENT_IN_CHECKOUT => 'Checkout',
        self::PAYMENT_CAPTURE => 'Capture',
        self::PAYMENT_AUTHORISE => 'Authorise',
        self::PAYMENT_FAIL => 'Fail',
    ];

    const STATUS_IN_CHECKOUT = 1;

    const STATUS_PLACED = 2;

    const STATUS_CONFIRM = 3;

    const STATUS_PROCESS = 4;

    const STATUS_MANIFEST = 5;

    const STATUS_DISPATCH = 6;

    const STATUS_DELIVER = 7;

    const STATUS_REPLACE = 8;

    const STATUS_RETURN = 9;

    const STATUS_CANCEL = 10;

    const STATUS_REJECT = 11;

    const STATUS_FAIL = 12;

    const STATUSES = [
        self::STATUS_IN_CHECKOUT => 'In Check Out',
        self::STATUS_PLACED => 'Placed',
        self::STATUS_CONFIRM => 'Confirmed',
        self::STATUS_PROCESS => 'Process',
        self::STATUS_MANIFEST => 'Manifested',
        self::STATUS_DISPATCH => 'Dispatch',
        self::STATUS_DELIVER => 'Delivered',
        self::STATUS_REPLACE => 'Replace',
        self::STATUS_RETURN => 'Return',
        self::STATUS_CANCEL => 'Cancelled',
        self::STATUS_REJECT => 'Rejected',
        self::STATUS_FAIL => 'Fail',
    ];

    const ADDRESS_EDIT_STATUS = [
        self::STATUS_IN_CHECKOUT => 1,
        self::STATUS_PLACED => 2,
        self::STATUS_CONFIRM => 3,
        self::STATUS_PROCESS => 4,
        self::STATUS_MANIFEST => 5,
        self::STATUS_DISPATCH => 6,
    ];

    const MC_INVOICE_PDF = 'invoice_pdf';

    const TYPE_CUSTOMER = 1;

    const TYPES = [
        self::TYPE_CUSTOMER => 'Customer',
    ];

    protected $guarded = ['id'];

    protected string $presenter = OrdersPresenter::class;

    public function getOrderStatusAttribute(): array
    {
        return ['id' => $this->status, 'value' => self::STATUSES[$this->status]];
    }

    public function hasCourierDetails(): bool
    {
        return $this->courier_partner && $this->courier_awb && $this->courier_tracking_url;
    }

    public function orderStatusLabel($status): string
    {
        switch ($status) {
            case '1':
                return $label = '<span class="label label-warning">In CheckOut</span>';
                break;
            case '2':
                return $label = '<span class="label label-success">Placed</span>';
                break;
            case '3':
                return $label = '<span class="label label-info">Confirmed</span>';
                break;
            case '4':
                return $label = '<span class="label label-pink">Process</span>';
                break;
            case '5':
                return $label = '<span class="label label-inverse">Manifested</span>';
                break;
            case '6':
                return $label = '<span class="label label-warning">Dispatch</span>';
                break;
            case '7':
                return $label = '<span class="label label-pink">Delivered</span>';
                break;
            case '8':
                return $label = '<span class="label label-danger">Replace</span>';
                break;
            case '9':
                return $label = '<span class="label label-danger">Return</span>';
                break;
            case '10':
                return $label = '<span class="label label-danger">Cancel</span>';
                break;
            case '11':
                return $label = '<span class="label label-danger">Rejected</span>';
                break;
            case '12':
                return $label = '<span class="label label-danger">Failed</span>';
                break;
        }

        return $status;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_INVOICE_PDF)
            ->singleFile();
    }

    public function isPaymentCheckout(): bool
    {
        return $this->payment_status == self::PAYMENT_IN_CHECKOUT;
    }

    public function isPaymentInCapture(): bool
    {
        return $this->payment_status == self::PAYMENT_CAPTURE;
    }

    public function isPaymentAuthorise(): bool
    {
        return $this->payment_status == self::PAYMENT_AUTHORISE;
    }

    public function isPaymentFailed(): bool
    {
        return $this->payment_status == self::PAYMENT_FAIL;
    }

    public function isCustomerOrder(): bool
    {
        return $this->type == self::TYPE_CUSTOMER;
    }

    public function getUniqueInvoiceNo(): string
    {
        $lastInvoiceCount = Order::wherePaymentStatus(Order::PAYMENT_CAPTURE)->count();
        do {
            $lastInvoiceCount++;
            $invoiceNo = $lastInvoiceCount;
        } while (Order::whereInvoiceNo($invoiceNo)->exists());

        return $invoiceNo;
    }

    /**
     * @return $this
     *
     * @throws Throwable
     */
    public function updateAndProcessPaymentStatus(string $transactionId): static
    {
        if ($this->payment_status == self::PAYMENT_IN_CHECKOUT || $this->payment_status == self::PAYMENT_AUTHORISE) {
            DB::transaction(function () use ($transactionId) {
                $amount = $this->cart_amount;

                try {
                    /** @var Payment $payment */
                    $payment = (new Api(env(''.settings('razor_pay_key')), env(''.settings('razor_pay_secret'))))
                        ->payment
                        ->fetch($transactionId)
                        ->capture(['amount' => $amount * 100]);

                    $pgResponse = $payment->toArray();
                } catch (Throwable $e) {
                    try {
                        /** @var Payment $payment */
                        $payment = (new Api(env(''.settings('razor_pay_key')), env(''.settings('razor_pay_secret'))))
                            ->payment
                            ->fetch($transactionId);

                        $pgResponse = $payment->toArray();
                    } catch (Throwable $e) {
                        $payment = $pgResponse = (object) ['status' => 'in-checkout'];
                    }
                }

                PaymentGatewayLog::create([
                    'order_id' => $this->id,
                    'response' => json_encode((array) $pgResponse),
                ]);

                if ($payment->status == 'captured') {
                    $this->payment_status = Order::PAYMENT_CAPTURE;
                    $this->status = Order::STATUS_PLACED;

                    OrderProduct::where('order_id', $this->id)
                        ->update(['status' => $this->status]);

                    foreach ($this->products as $product) {
                        $product->companyStockLedger()->create([
                            'product_id' => $product->product->id,
                            'type' => CompanyStockLedger::TYPE_OUTWARD,
                            'quantity' => $product->quantity,
                            'amount' => $product->dp * $product->quantity,
                        ]);

                        $product->product->decrement('company_stock', $product->quantity);
                    }
                } elseif ($payment->status == 'authorized') {
                    $this->payment_status = Order::PAYMENT_AUTHORISE;
                } elseif ($payment->status == 'failed') {
                    $this->payment_status = Order::PAYMENT_FAIL;
                    $this->status = Order::STATUS_FAIL;
                } elseif ($payment->status == 'in-checkout') {
                    $this->payment_status = Order::PAYMENT_IN_CHECKOUT;
                }

                $this->transaction_id = $transactionId;
                $this->save();
            });

            if (in_array($this->payment_status, [Order::PAYMENT_FAIL, Order::PAYMENT_IN_CHECKOUT])) {
                if ($this->wallet > 0) {
                    /// wallet amount credit for order fail
                    //                    $this->shoppingWalletTransaction()->create([
                    //                        'member_id' => $this->member_id,
                    //                        'opening_balance' => $this->member->shopping_wallet,
                    //                        'closing_balance' => $this->member->shopping_wallet + $this->wallet,
                    //                        'amount' => $this->wallet,
                    //                        'type' => ShoppingWalletTransaction::TYPE_CREDIT,
                    //                        'comment' => 'Amount credit for fail order : ' . $this->order_no
                    //                    ]);
                }
            }

            if ($this->payment_status == self::PAYMENT_CAPTURE) {
                //                job call for income and bv
                //                ProcessOrderBV::dispatch($this);
                SendOrderPlacedSMS::dispatch($this);
            }
        }

        return $this;
    }

    public function member(): BelongsTo|Member
    {
        return $this->belongsTo(Member::class);
    }

    public function products(): OrderProduct|HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function scopePaymentCaptured(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.payment_status", self::PAYMENT_CAPTURE);
    }

    public function scopeCustomerOrder(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.type", self::TYPE_CUSTOMER);
    }

    public function scopeMinBv(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.total_bv", '>=', $min);
    }

    public function scopeMaxBv(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.total_bv", '<=', $max);
    }

    public function scopeMinTotalMrp(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.total_mrp", '>=', $min);
    }

    public function scopeMaxTotalMrp(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.total_mrp", '<=', $max);
    }

    public function scopeMinTotalItems(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.total_items", '>=', $min);
    }

    public function scopeMaxTotalItems(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.total_items", '<=', $max);
    }

    public function scopeMinTotalTaxableAmount(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.total_taxable_value", '>=', $min);
    }

    public function scopeMaxTotalTaxableAmount(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.total_taxable_value", '<=', $max);
    }

    public function scopeMinTotalDp(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.total_dp", '>=', $min);
    }

    public function scopeMaxTotalDp(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.total_dp", '<=', $max);
    }

    public function scopeMinTotalGstAmount(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.total_gst_amount", '>=', $min);
    }

    public function scopeMaxTotalGstAmount(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.total_gst_amount", '<=', $max);
    }

    public function scopeMinTotal(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.total", '>=', $min);
    }

    public function scopeMaxTotal(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.total", '<=', $max);
    }

    public function scopeMinShippingCharge(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.shipping_charge", '>=', $min);
    }

    public function scopeMaxShippingCharge(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.shipping_charge", '<=', $max);
    }

    public function state(): BelongsTo|State
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo|City
    {
        return $this->belongsTo(City::class);
    }

    public function isAddressEditable(): bool
    {
        if (in_array($this->status, self::ADDRESS_EDIT_STATUS)) {
            return true;
        } else {
            return false;
        }
    }
}
