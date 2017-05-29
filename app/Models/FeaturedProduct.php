<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedProduct extends Model
{
    protected $fillable = [
        'product_id'
    ];

    protected $table="featured_products";

    public function product() {
        return $this->belongsTo("\App\Product");
    }
}
