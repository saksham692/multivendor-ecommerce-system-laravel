<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory, sluggable;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'is_active',
        'is_featured',
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
        return $this->belongsToMany(Product::class, 'label_product', 'label_id', 'product_id');
    }


}
