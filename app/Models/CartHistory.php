<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartHistory extends Model
{
    public function user() {
        return $this->belongsTo("App\User");
    }

    public function shop() {
        return $this->belongsTo("App\User");
    }

    public function product() {
        return $this->belongsTo("App\Product");
    }

    public function scopeSeller($query) {
        $query->where("shop_id", "=", \Auth::user()->id)->where("status", "<", 4);
    }
}

