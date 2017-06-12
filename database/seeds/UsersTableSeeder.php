<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'DOD-EGY', 'email' => 'mera_shaker@yahoo.com', 'password' => bcrypt('123456'), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'Smart World', 'email' => 'muhammedmagdi2017@gmail.com', 'password' => bcrypt('123456'), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'Abbas Mounir', 'email' => 'abbas@gmail.com', 'password' => bcrypt('123456'), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'Saleh Zaki', 'email' => 'saleh@gmail.com', 'password' => bcrypt('123456'), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["name" => "Administrator", "email" => "admin@gadget.ly", "password" => bcrypt("123456"), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["name" => "Kamel Mansour", "email" => "kamel@gmail.com", "password" => bcrypt("123456"), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["name" => "Shahenda Malek", "email" => "shahenda@gmail.com", "password" => bcrypt("123456"), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => 'Simona Soliman', 'email' => 'simona@gmail.com', 'password' => bcrypt('123456'), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['name' => ' Uvuvwevwevwe Onyetenyevwe Ugwemubwem Ossas', 'email' => 'osas@gmail.com', 'password' => bcrypt('123456'), "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);

        DB::table("employees")->insert([
            ["employee_id" => 4, "manager_id" => 1, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["employee_id" => 5, "manager_id" => 1, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["employee_id" => 9, "manager_id" => 2, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["employee_id" => 10, "manager_id" => 2, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);

        DB::table('role_user')->insert([
            ["user_id" => 1, "role_id" => 1, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['user_id' => 2, 'role_id' => 3, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 3, "role_id" => 3, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 4, "role_id" => 4, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 5, "role_id" => 4, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 6, "role_id" => 2, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 7, "role_id" => 5, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 8, "role_id" => 5, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 9, "role_id" => 4, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 10, "role_id" => 4, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);

        DB::table("user_details")->insert([
            ["user_id" => 1, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 2, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 3, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 4, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 5, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 6, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 7, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 8, "gender" => '1', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 9, "gender" => '1', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 10, "gender" => '0', "status" => '0', "date_of_birth" => "1994-06-11", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);

        DB::table("user_phones")->insert([
            ["user_id" => 2, "number" => "01123456789", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 3, "number" => "01123456789", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);

        DB::table("user_addresses")->insert([
            ["user_id" => 2, "address" => "Cecilia Chapman 711-2880 Nulla St.Mankato Mississippi 96522 (257) 563-7401", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 3, "address" => "Iris Watson P.O. Box 283 8562 Fusce Rd. Frederick Nebraska 20620 (372) 587-2335", "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);

        DB::table("shopping_carts")->insert([
            ["user_id" => 7, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ["user_id" => 8, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
        ]);
    }
}
