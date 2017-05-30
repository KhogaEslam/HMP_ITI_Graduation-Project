<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerRequest extends Model
{
    protected $fillable = ["type", "start_date", "end_date","image","connected_id"];

    public function scopeCurrent($query) {
        $query->where("start_date", "<=", \Carbon\Carbon::now())
            ->where("end_date", ">=", \Carbon\Carbon::now());
    }
}
