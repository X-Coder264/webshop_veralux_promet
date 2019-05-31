<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_subcategory')->unsigned()->index();
            $table->foreign('parent_subcategory')->references('id')->on('product_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            /*$table->decimal('price', 7, 2)->default(0);
            $table->decimal('discount_price', 7, 2)->default(0);
            $table->enum('currency', ['HRK', 'EUR', 'USD']);
            $table->boolean('discount')->default(0);*/
            $table->integer('manufacturer_id')->unsigned()->index();
            $table->foreign('manufacturer_id')->references('id')->on('product_manufacturers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('catalogNumber')->unique();
            $table->string('EAN')->unique();
            $table->text('description');
            $table->enum('unit', ['kom', 'm', 'kg']);
            $table->boolean('highlighted')->default(false);
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
