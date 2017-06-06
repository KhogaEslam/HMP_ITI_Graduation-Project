<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    //
    protected $fillable = [
        "about_gadgetly",
        "laptops",
        "tablets",
        "mobiles"
    ];

    protected $table="about";
}
