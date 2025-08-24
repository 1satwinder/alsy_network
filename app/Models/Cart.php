<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $member_id
 * @property string $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function addToCart($member, $productId, $qty)
    {
        if ($cart = Cart::where('member_id', $member->id)->first()) {
            $product = json_decode($cart->details, true);
            if (collect($product)->where('product_id', $productId)->first()) {
                $productArray = collect($product)->map(function ($data) use ($qty, $productId) {
                    if ($data['product_id'] == $productId) {
                        $data['selected_qty'] = $qty;
                    }

                    return $data;
                });

                Cart::where('member_id', $member->id)->update([
                    'details' => json_encode($productArray),
                ]);
                $cart->refresh();
            } else {
                $newProduct = ['product_id' => $productId, 'selected_qty' => $qty];
                $productArray = collect($product)->merge([$newProduct]);

                Cart::where('member_id', $member->id)
                    ->update([
                        'details' => json_encode($productArray),
                    ]);
                $cart->refresh();
            }
        } else {
            $productArray = ['product_id' => $productId, 'selected_qty' => $qty];
            $cart = Cart::create([
                'member_id' => $member->id,
                'details' => json_encode([$productArray]),
            ]);
        }

        return json_decode($cart->details);
    }

    public static function getDetail($member): object
    {
        $cart = Cart::where('member_id', $member->id)->first();
        $productDetails = [];
        $totalDp = 0;
        $totalMrp = 0;
        $totalBv = 0;
        $totalShipping = 0;
        if ($cart) {
            $details = json_decode($cart->details);
            $productDetails = collect($details)->map(function ($detail) use (&$totalShipping, &$totalBv, &$totalMrp, &$totalDp) {
                $product = Product::with('media')
                    ->where('id', $detail->product_id)->first();
                if ($product && $detail->selected_qty) {
                    $subTotalDp = ($product->dp * $detail->selected_qty);
                    $subTotalMrp = ($product->mrp * $detail->selected_qty);
                    $subTotalBv = ($product->bv * $detail->selected_qty);
                    $subTotalShipping = 0;
                    $totalMrp += $subTotalMrp;
                    $totalDp += $subTotalDp;
                    $totalBv += $subTotalBv;

                    if (settings('shipping_charge') && settings('shipping_on_product')) {
                        $subTotalShipping = ($product->shipping_charge * $detail->selected_qty);
                        $totalShipping += $subTotalShipping;
                    }

                    return (object) array_merge($product->toArray(), [
                        'selected_qty' => (int) $detail->selected_qty,
                        'imageUrl' => $product->getFirstMediaUrl(Product::MC_PRODUCT_IMAGE),
                        'subTotalDp' => $subTotalDp,
                        'subTotalBv' => $subTotalBv,
                        'subTotalMrp' => $subTotalMrp,
                        'subTotalShipping' => $subTotalShipping,
                    ]);
                }
            })->filter()->values();
        }
        if (settings('shipping_charge') && settings('shipping_on_cart')) {
            $shippingDetail = ShippingDetail::orderBy('id', 'desc')
                ->where('status', ShippingDetail::STATUS_ACTIVE)
                ->first();
            if ($shippingDetail && $totalDp < $shippingDetail->amount) {
                $totalShipping = $shippingDetail->charge;
            }
        }

        return (object) [
            'products' => $productDetails,
            'totalDp' => $totalDp,
            'totalMrp' => $totalMrp,
            'totalBv' => $totalBv,
            'totalShipping' => $totalShipping,
        ];
    }
}
