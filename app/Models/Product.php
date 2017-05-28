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
        $user = \Auth::user();
        if($user->hasRole("employee")) {
            $user = $user->employee->where("employee_id", "=", $user->id)->first()->manager;
        }
        $query->where("user_id", "=", $user->id);
    }

    public function images() {
        return $this->hasMany("\App\ProductImage");
    }

    public function scopePublished($query) {
        $query->where("published", "=", true);
    }
}
