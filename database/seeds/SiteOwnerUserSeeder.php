<?php

use Illuminate\Database\Seeder;

class SiteOwnerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Site Owner', 'email' => 'owner@gadget.ly', 'password' => bcrypt('123456'), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);

        DB::table('role_user')->insert([
            ["user_id" => 1, "role_id" => 1, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);

        DB::table("user_details")->insert([
            ["user_id" => 1, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);
    }
}
