<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanUser extends Model
{
    protected $table ='plans_users';

    public function user() {
        return $this->belongsTo("App\User", "user_id");
    }

    public function plan() {
        return $this->belongsTo("App\VendorPlan", "plan_id");
    }
}
