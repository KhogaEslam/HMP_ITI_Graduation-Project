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
        // insert site owner user with his role
        DB::table('users')->insert([
            'name' => 'Site Owner',
            'email' => 'owner@hmp.local',
            'password' => bcrypt('123456'),
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);
    }
}
