<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Punjač XY ftw 88',
            'parent_subcategory' => 8,
            //'price' => 50,
            //'currency' => 'HRK',
            'description' => 'Najbolji punjač na svijetu!',
            'slug' => 'punjac-xy-ftw-88',
            //'discount' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'name' => 'Punjač ZT Smeće',
            'parent_subcategory' => 8,
            //'price' => 200,
            //'currency' => 'HRK',
            'description' => 'Nemoj kupovati pls!',
            'slug' => 'punjac-zt-smece',
            //'discount' => true,
            //'discount_price' => 185,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
