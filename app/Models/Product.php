<?php

namespace App\Models;

use App\Presenters\ProductPresenter;
use App\Traits\CreationDateRangeScopes;
use App\Traits\HasStocks;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $category_id
 * @property int|null $g_s_t_type_id
 * @property string $name
 * @property string|null $slug
 * @property string $sku
 * @property string $mrp
 * @property string $dp
 * @property string $bv
 * @property string $opening_stock
 * @property string $company_stock
 * @property int $status 1: Active, 2: In-Active
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\GSTType|null $GSTType
 * @property-read \App\Models\Category|null $category
 * @property-read Collection<int, \App\Models\CompanyStockLedger> $companyStockLedger
 * @property-read int|null $company_stock_ledger_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Package|null $package
 * @method static Builder|Product active()
 * @method static Builder|Product createdAtFrom(string $date)
 * @method static Builder|Product createdAtTo(string $date)
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static Builder|Product maxBv($max)
 * @method static Builder|Product maxDp($max)
 * @method static Builder|Product maxMrp($max)
 * @method static Builder|Product maxStock($max)
 * @method static Builder|Product minBv($min)
 * @method static Builder|Product minDp($min)
 * @method static Builder|Product minMrp($min)
 * @method static Builder|Product minStock($min)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBv($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereCompanyStock($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereDp($value)
 * @method static Builder|Product whereGSTTypeId($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereMrp($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereOpeningStock($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereStatus($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Product extends Model implements HasMedia
{
    use CreationDateRangeScopes;
    use HasFactory;
    use HasSlug;
    use HasStocks;
    use InteractsWithMedia;
    use PresentableTrait;

    const STATUS_ACTIVE = 1;

    const STATUS_IN_ACTIVE = 2;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_IN_ACTIVE => 'In-Active',
    ];

    const MC_PRODUCT_IMAGE = 'product_image';

    const MC_PRODUCT_SUB_IMAGE = 'product_sub_image';

    public array $translatable = ['name', 'slug'];

    protected $guarded = [];

    protected string $presenter = ProductPresenter::class;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_PRODUCT_IMAGE)
            ->singleFile();

        $this->addMediaCollection(self::MC_PRODUCT_SUB_IMAGE);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function package(): BelongsTo|Package
    {
        return $this->belongsTo(Package::class);
    }

    public function category(): BelongsTo|Category
    {
        return $this->belongsTo(Category::class);
    }

    public function GSTType(): BelongsTo
    {
        return $this->belongsTo(GSTType::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.status", self::STATUS_ACTIVE);
    }

    public function scopeCreatedAtFrom(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeCreatedAtTo(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }

    public function scopeMinMrp(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.mrp", '>=', $min);
    }

    public function scopeMaxMrp(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.mrp", '<=', $max);
    }

    public function scopeMinDp(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.dp", '>=', $min);
    }

    public function scopeMaxDp(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.dp", '<=', $max);
    }

    public function scopeMinBv(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.bv", '>=', $min);
    }

    public function scopeMaxBv(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.bv", '<=', $max);
    }

    public function scopeMinStock(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.company_stock", '>=', $min);
    }

    public function scopeMaxStock(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.company_stock", '<=', $max);
    }
}
