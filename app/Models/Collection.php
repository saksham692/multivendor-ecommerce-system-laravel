<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory, sluggable;

    protected $fillable = [
        'name',
        'slug',
        'is_featured',
        'is_active',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'collection_product', 'collection_id', 'product_id');
    }


}
