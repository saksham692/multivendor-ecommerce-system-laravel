<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, sluggable;

    protected $fillable = [
        'is_active',
        'is_digital',
        'is_featured',
        'brand_id',
        'name',
        'slug',
        'description',
        'thumbnail_img',
        'images',
        'cost_price',
        'price',
        'stock_status',
        'sku',
        'barcode',
        'current_stock',
        'weight',
        'length',
        'width',
        'height',
        'label',
        'collection',
        'seo_description',
        'tags',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_product', 'product_id', 'attribute_id');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_product', 'product_id', 'collection_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'label_product', 'product_id', 'label_id');
    }

    public function taxes()
    {
        return $this->hasMany(ProductTax::class, 'product_id', 'id');
    }

    public function wholesales()
    {
        return $this->hasMany(ProductWholesale::class, 'product_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /** Scopes */

    public function scopeBestSelling(Builder $query)
    {
        return $query->orderByDesc('sold_count')
            ->limit(1)
            ->when($query->count() == 0, function ($subQuery) {
                $subQuery->inRandomOrder()->limit(1);
            });
    }

    /**
     * Scope for featured products.
     */
    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true)
            ->limit(1)
            ->when($query->count() == 0, function ($subQuery) {
                $subQuery->inRandomOrder()->limit(1);
            });
    }

    /**
     * Scope for recently viewed products.
     */
    public function scopeRecentlyViewed(Builder $query)
    {
        return $query->orderByDesc('last_viewed_at')
            ->limit(1)
            ->when($query->count() == 0, function ($subQuery) {
                $subQuery->inRandomOrder()->limit(1);
            });
    }

}
