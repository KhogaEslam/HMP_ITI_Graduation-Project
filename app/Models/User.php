<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable //Entrust configuration needs User model to extends "Eloquent" !
{
    use EntrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', '',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userDetails() {
        return $this->hasOne("\App\UserDetail");
    }

    public function role() {
        return $this->belongsTo("\App\Role");
    }

    public function addresses() {
        return $this->hasMany("\App\UserAddress");
    }

    public function products() {
        return $this->hasMany("\App\Product");
    }
}
