<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    public function cart() {
        return $this->belongsTo("\App\ShoppingCart");
    }

    public function product() {
        return $this->belongsTo("\App\Product");
    }


    public function scopeQuantity($query, $product) {
        $query->where("product_id", "=", $product);
    }

    public function alreadyExist($product) {
        return $this->attributes["product_id"] == $product->id;
    }
}
