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

    public function phones() {
        return $this->hasMany("\App\UserPhone");
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

    public function ratings()
    {
        return $this->hasMany("\App\Rating");
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


    public function checkouts() {
        return $this->hasMany("\App\CartHistory", "user_id");
    }

    public function currentCheckouts() {
        return $this->hasMany("\App\CurrentCheckout", "user_id");
    }

    public function checkoutRequests() {
        return $this->hasMany("\App\CartHistory", "shop_id");
    }

    public function currentCheckoutRequests() {
        return $this->hasMany("\App\CurrentCheckout", "shop_id");
    }

    /**
     * Return the user attributes.

     * @return array
     */
    public static function getAuthor($id)
    {
        $user = self::find($id);
        return [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'url'    => '',  // Optional
            'avatar' => 'gravatar',  // Default avatar
            'admin'  => $user->role === 'admin', // bool
        ];
    }

    public function plan(){
        return $this->hasOne("\App\PlanUser",'plan_id');
    }
}
