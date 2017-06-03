<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected  $fillable = [
        'user_id',
        'product_id',
        'star'
    ];

    public function product() {
        return $this->belongsTo("\App\Product");
    }

    public function user() {
        return $this->belongsTo("\App\User");
    }
}
