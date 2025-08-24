<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SupplierInvoice
 *
 * @property int $id
 * @property int $supplier_id
 * @property string $invoice_no
 * @property \Illuminate\Support\Carbon $invoice_date
 * @property int $quantity
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CompanyStockLedger> $companyStockLedger
 * @property-read int|null $company_stock_ledger_count
 * @property-read \App\Models\Supplier $supplier
 * @method static Builder|SupplierInvoice fromDate($fromDate)
 * @method static Builder|SupplierInvoice maxAmount($max)
 * @method static Builder|SupplierInvoice maxQuantity($max)
 * @method static Builder|SupplierInvoice minAmount($min)
 * @method static Builder|SupplierInvoice minQuantity($min)
 * @method static Builder|SupplierInvoice newModelQuery()
 * @method static Builder|SupplierInvoice newQuery()
 * @method static Builder|SupplierInvoice query()
 * @method static Builder|SupplierInvoice toDate($toDate)
 * @method static Builder|SupplierInvoice whereAmount($value)
 * @method static Builder|SupplierInvoice whereCreatedAt($value)
 * @method static Builder|SupplierInvoice whereId($value)
 * @method static Builder|SupplierInvoice whereInvoiceDate($value)
 * @method static Builder|SupplierInvoice whereInvoiceNo($value)
 * @method static Builder|SupplierInvoice whereQuantity($value)
 * @method static Builder|SupplierInvoice whereSupplierId($value)
 * @method static Builder|SupplierInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SupplierInvoice extends Model
{
    protected $guarded = [];

    protected $casts = ['invoice_date' => 'datetime'];

    /**
     * @return BelongsTo|Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function companyStockLedger()
    {
        return $this->morphMany(CompanyStockLedger::class, 'responsible');
    }

    /**
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeFromDate(Builder $query, $fromDate)
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $fromDate);
    }

    /**
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeToDate(Builder $query, $toDate)
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $toDate);
    }

    /**
     * @return Builder
     */
    public function scopeMinQuantity(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.quantity", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxQuantity(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.quantity", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinAmount(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.amount", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxAmount(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.amount", '<=', $max);
    }
}
