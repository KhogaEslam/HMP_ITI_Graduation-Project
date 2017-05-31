<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventForActiveBanner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            delimiter |
            CREATE EVENT `update_current_active_banner`
            ON SCHEDULE
                EVERY 1 DAY
            COMMENT \'Updating Current Active Banner.\'    
            
            DO
                BEGIN
                    TRUNCATE TABLE `active_banners`;
                    
                    INSERT INTO `hmp.active_banners` (banner_id)
                        SELECT id
                            FROM hmp.banner_requests
                            WHERE ;                                                       
                END |
            
            delimiter ;    
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP EVENT IF EXIST `update_current_active_banner`');
    }
}
