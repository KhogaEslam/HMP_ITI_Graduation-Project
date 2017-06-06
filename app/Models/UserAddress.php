<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = ["address"];

    public function user() {
        return $this->belongsTo("\App\User");
    }
}
