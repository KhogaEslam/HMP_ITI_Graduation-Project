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
}
