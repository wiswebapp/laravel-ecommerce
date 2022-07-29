<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned();
            $table->string('product_slug');
            $table->string('product_name');
            $table->text('product_short_description');
            $table->text('product_long_description');
            $table->string('product_image');
            $table->float('price',10,2);
            $table->integer('stock_count')->unsigned();
            $table->enum('is_available',['Yes','No'])->default('Yes');
            $table->enum('status',['Active','InActive'])->default('Active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('subcategory_id')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
