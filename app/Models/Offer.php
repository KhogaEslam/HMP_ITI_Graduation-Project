<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ["percentage", "start_date", "end_date"];

    public function scopeCurrent($query) {
        $query->where("start_date", "<=", \Carbon\Carbon::now())
            ->where("end_date", ">=", \Carbon\Carbon::now());
    }
}
