<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'owner', 'display_name' => 'Site Owner', 'description' => 'The Site Owner', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'admin', 'display_name' => 'Site Administrator', 'description' => 'The Site Administrator', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'shop', 'display_name' => 'Shop Owner', 'description' => 'The Shop Owner', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'employee', 'display_name' => 'Employee', 'description' => 'Managing products', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'customer', 'display_name' => 'Site Customer', 'description' => 'The site Customer', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ];
        DB::table('roles')->insert($roles);
    }
}
