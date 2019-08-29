<?php

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
            $table->uuid('id')->primary();
            $table->uuid("user_id");
            $table->unsignedBigInteger("category_id")->nullable();
            $table->string("name");
            $table->string("description");
            $table->string("image")->nullable();
            $table->unsignedInteger("base_price")->default(0);
            $table->unsignedInteger("sell_price")->default(0);
            $table->unsignedTinyInteger("label_id")->default(0);
            $table->softDeletes();
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
