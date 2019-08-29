<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid("transaction_id");
            $table->string("product_id")->nullable();
            $table->string("product_name");
            $table->unsignedInteger("product_price");
            $table->unsignedInteger("product_base_price");
            $table->unsignedInteger("quantity");
            $table->unsignedInteger("subtotal");
            $table->text("notes")->nullable();
            $table->timestamps();

            $table->foreign("transaction_id")->references("id")->on("transactions")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
