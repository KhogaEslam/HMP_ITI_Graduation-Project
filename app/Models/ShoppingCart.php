<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    public function user() {
        return $this->belongsTo("\App\User");
    }

    public function cartDetails()
    {
        return $this->hasMany("\App\CartDetail", "cart_id");
    }
}
