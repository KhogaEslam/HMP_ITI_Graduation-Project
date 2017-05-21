<?php
/**
 * Created by PhpStorm.
 * User: khoga
 * Date: 21/05/17
 * Time: 08:02 م
 */

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    public function users() {
        return $this->hasMany(users, "user_id");
    }
}