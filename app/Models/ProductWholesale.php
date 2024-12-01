<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWholesale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'min_qty',
        'max_qty',
        'price',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

}
