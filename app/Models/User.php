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

    public function employee() {
        return $this->hasMany("App\Employee", "employee_id");
    }


    public function featured()
    {
        return $this->hasone("\App\Discount");
    }

    public function wishlists()
    {
        return $this->hasMany("\App\WishList");
    }

    public function cart() {
        return $this->hasOne("App\ShoppingCart");

    }

    /**
     * Get all of the user's Banners.
     */
//    public function banners()
//    {
//        return $this->morphMany('App\BannerRequest', 'connected');
//    }

    public function comments()
    {
        return $this->hasMany(\Laravelista\Comments\Comments\Comment::class);
    }
}
