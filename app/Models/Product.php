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
        $query->where("user_id", "=", \Auth::user()->id);
    }

    public function images() {
        return $this->hasMany("\App\ProductImage");
    }
}
