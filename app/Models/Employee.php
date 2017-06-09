<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ["employee_id", "manager_id"];

    public function manager() {
        return $this->belongsTo("App\User", "manager_id");
    }

    public function self() {
        return $this->belongsTo("App\User", "employee_id");
    }
}
