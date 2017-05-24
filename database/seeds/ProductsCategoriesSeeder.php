<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            'name' => 'Adapteri',
            'category_parent_id' => 0,
            'slug' => 'adapteri',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('product_categories')->insert([
            'name' => 'Punjači',
            'category_parent_id' => 1,
            'slug' => 'punjaci',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('product_categories')->insert([
            'name' => 'Napajanja',
            'category_parent_id' => 1,
            'slug' => 'napajanja',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('product_categories')->insert([
            'name' => 'Klime',
            'category_parent_id' => 0,
            'slug' => 'klime',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('product_categories')->insert([
            'name' => 'Klime podkategorija',
            'category_parent_id' => 4,
            'slug' => 'klime-podkategorija',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('product_categories')->insert([
            'name' => 'Napajanje podkategorija',
            'category_parent_id' => 3,
            'slug' => 'napajanje-podkategorija',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('product_categories')->insert([
            'name' => 'Punjači podkategorija',
            'category_parent_id' => 2,
            'slug' => 'punjaci-podkategorija',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('product_categories')->insert([
            'name' => 'Punjači podpodkategorija',
            'category_parent_id' => 7,
            'slug' => 'punjaci-podpodkategorija',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
