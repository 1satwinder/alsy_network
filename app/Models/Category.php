<?php

namespace App\Models;

use App\Presenters\CategoryPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $prefix
 * @property int $status 1: Active, 2: In-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read Category|null $parent
 * @property-read Collection<int, \App\Models\Product> $product
 * @property-read int|null $product_count
 * @method static Builder|Category active()
 * @method static Builder|Category createdAtFrom(string $date)
 * @method static Builder|Category createdAtTo(string $date)
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static Builder|Category firstLevel()
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category wherePrefix($value)
 * @method static Builder|Category whereStatus($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia,PresentableTrait;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In-Active',
    ];

    public $translatable = ['name', 'prefix'];

    protected $guarded = ['id'];

    protected $presenter = CategoryPresenter::class;

    const MC_CATEGORY_IMAGE = 'category_image';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_CATEGORY_IMAGE)
            ->singleFile();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('prefix');
    }

    public function parent(): BelongsTo|self
    {
        return $this->belongsTo(self::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isInActive(): bool
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.status", self::STATUS_ACTIVE);
    }

    public function scopeFirstLevel(Builder $query): Builder
    {
        return $query->whereNull("{$this->getTable()}.parent_id");
    }

    public function children(): HasMany|self
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function scopeCreatedAtFrom(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeCreatedAtTo(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }
}
