<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ["name" => "Laptops"],
            ["name" => "Smart phones"],
            ["name" => "Smart watches"]
        ];

        \DB::table("categories")->insert($categories);
    }
}
