<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('so_code');
            $table->integer('visit_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('user_name')->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('store_name')->nullable();
            $table->integer('store_code')->nullable();
            $table->string('ref_no');
            $table->json('products');
            $table->double('total_price');
            $table->float('total_qty');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
