<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveBanner extends Model
{
    public function banner(){
        return $this->belongsTo("\App\BannerRequest");
    }
}
