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
        DB::unprepared('SET GLOBAL event_scheduler = ON');

        DB::unprepared('
            CREATE EVENT `update_current_active_banner`
            ON SCHEDULE
                EVERY 1 DAY
                STARTS (TIMESTAMP(CURRENT_DATE))             
            DO
                BEGIN
                    TRUNCATE TABLE `active_banners`;
                    
                    INSERT INTO `active_banners` (`active_banners`.`banner_id`)
                        SELECT `banner_requests`.`id`
                            FROM `banner_requests`
                            WHERE DATE(`banner_requests`.`start_date`) = CURDATE()
                            AND `banner_requests`.`status` = 1
                            LIMIT 1;                                                       
                END        
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP EVENT update_current_active_banner');
    }
}
