<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'values',
        'is_active',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_product', 'attribute_id', 'product_id');
    }


}
