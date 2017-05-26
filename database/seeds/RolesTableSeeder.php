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
            ['name' => 'owner', 'display_name' => 'Site Owner', 'description' => 'The Site Owner'],
            ['name' => 'admin', 'display_name' => 'Site Administrator', 'description' => 'The Site Administrator'],
            ['name' => 'vendor', 'display_name' => 'Shop Owner', 'description' => 'The Shop Owner'],
            ['name' => 'employee', 'display_name' => 'Employee', 'description' => 'Managing products'],
            ['name' => 'customer', 'display_name' => 'Site Customer', 'description' => 'The site Customer'],
        ];
        DB::table('roles')->insert($roles);
    }
}
