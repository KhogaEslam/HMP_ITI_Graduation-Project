<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id'
    ];

    protected $table="featured_requests";

    public function product() {
        return $this->belongsTo("\App\Product");
    }

    public function user() {
        return $this->belongsTo("\App\User");
    }
}