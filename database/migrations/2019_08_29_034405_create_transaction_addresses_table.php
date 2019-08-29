<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("transaction_id");
            $table->string("name");
            $table->text("address");
            $table->string("hint")->nullable();
            $table->string("recipient");
            $table->string("phone");
            $table->string("lat")->nullable();
            $table->string("lng")->nullable();
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
        Schema::dropIfExists('transaction_addresses');
    }
}
