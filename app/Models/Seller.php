<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory, sluggable;

    protected $fillable = [
        'is_approved',
        'user_id',
        'shop_name',
        'status',
        'phone',
        'email',
        'banner',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'description',
        'facebook',
        'instagram',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state(){
        return $this->belongsTo(State::class, 'country_id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'country_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'shop_name'
            ]
        ];
    }

}
