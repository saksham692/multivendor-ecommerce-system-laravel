<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTax extends Model
{
    use HasFactory, sluggable;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

}
