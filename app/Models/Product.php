<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "description",
        "price",
        "quantity",
    ];

    public function category() {
        return $this->belongsTo("\App\Category");
    }

    public function user() {
        return $this->belongsTo("\App\User");
    }

    public function scopeOwned($query) {
        $user = \Auth::user();
        if($user->hasRole("employee")) {
            $user = $user->employee->where("employee_id", "=", $user->id)->first()->manager;
        }
        $query->where("user_id", "=", $user->id);
    }

    public function images() {
        return $this->hasMany("\App\ProductImage");
    }

    public function scopePublished($query) {
        $query->where("published", "=", true);
    }

    public function isPublished() {
        return $this->published;
    }

    public function discount() {
        return $this->hasone("\App\Discount");
    }


    public function featured()
    {
        return $this->hasone("\App\FeaturedItem");
    }

    public function featuredProduct()
    {
        return $this->hasone("\App\FeaturedProduct");
    }


    public function carts() {
        return $this->hasMany("\App\CartDetail", "product_id");
    }

    public function getPriceAttribute() {
        $price = $this->attributes['price'];
        if(! Offer::current()->get()->isEmpty()) {
            $price *= Offer::all()->current->first()->percentage / 100.0;
        }
        if(! $this->discount()->get()->isEmpty()) {
            $price *= $this->discount()->first()->percentage / 100;
        }
        return $price;
    }
}
