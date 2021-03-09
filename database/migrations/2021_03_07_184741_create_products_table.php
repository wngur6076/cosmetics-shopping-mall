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
            $table->id();
            $table->string('confirmation_number');
            $table->string('poster_image_path');
            $table->string('brand');
            $table->string('title');
            $table->integer('price');
            $table->integer('discount_rate')->default(0);
            $table->string('capacity');
            $table->integer('quantity');
            $table->integer('delivery');
            $table->integer('review_grade')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('sold_count')->default(0);
            $table->timestamps();
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
