<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPlan extends Model
{
    public function user() {
        return $this->hasMany("\App\PlanUser",'user_id');
    }
}
