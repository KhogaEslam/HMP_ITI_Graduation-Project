<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    public function cart() {
        return $this->belongsTo("\App\ShoppingCart");
    }

    public function product() {
        return $this->belongsTo("\App\User");
    }


    public function scopeQuantity($query, $product) {
        $query->where("product_id", "=", $product);
    }
}
