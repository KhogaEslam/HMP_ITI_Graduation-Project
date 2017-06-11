<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPlan extends Model
{
    public function user() {
        return $this->belongsTo("\App\User");
    }
}
