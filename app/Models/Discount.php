<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        "percentage",
        "start_date",
        "end_date",
        "product_id"
    ];

    protected $table="product_discounts";

    public function product() {
        return $this->belongsTo("\App\Product");
    }
}