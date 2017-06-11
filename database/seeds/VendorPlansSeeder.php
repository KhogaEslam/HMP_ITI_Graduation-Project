<?php

use Illuminate\Database\Seeder;

class VendorPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            ['name' => 'SMALL PLAN', 'description' => '10 Products , 1 Featured Item/Quarter ', 'period' => 3, 'price' => 10.0],
            ['name' => 'MEDIUM PLAN', 'description' => '30 Products , 3 Featured Item/Quarter ', 'period' => 3, 'price' => 30.0],
            ['name' => 'FULL PLAN', 'description' => '50 Products , 5 Featured Item/Quarter ', 'period' => 3, 'price' => 50.0],
        ];
        DB::table('vendor_plans')->insert($plans);
    }
}
