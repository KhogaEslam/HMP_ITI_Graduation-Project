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

    public function wishlists()
    {
        return $this->hasMany("\App\WishList");
    }

    public function ratings()
    {
        return $this->hasMany("\App\ProductRate");
    }

    public function carts() {
        return $this->hasMany("\App\CartDetail", "product_id");
    }

    public function getDiscountAttribute() {
        $discount = 0;
        if(! $this->discount()->get()->isEmpty()) {
            $discount = $this->discount()->first()->percentage;
        }
        return $discount;
    }

    public function getOfferAttribute() {
        $offer = 0;
        if(! Offer::current()->get()->isEmpty()) {
            $offer = Offer::current()->first()->percentage;
        }
        return $offer;
    }

    /**
     * Get all of the Product's Banners.
     */
//    public function banners()
//    {
//        return $this->morphMany('App\BannerRequest', 'connected');
//    }
}
