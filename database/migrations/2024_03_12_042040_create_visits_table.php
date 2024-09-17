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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id')->nullable();
            $table->string('store_name');
            $table->string('store_code');
            $table->string('so_code')->nullable();
            $table->string('note')->nullable();
            $table->text('image');
            $table->date('in_date')->nullable();
            $table->time('in_time')->nullable();
            $table->string('in_lat')->nullable();
            $table->string('in_long')->nullable();
            $table->date('out_date')->nullable();
            $table->time('out_time')->nullable();
            $table->string('out_lat')->nullable();
            $table->string('out_long')->nullable();
            $table->json('user_login');
            $table->integer('user_id');
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
        Schema::dropIfExists('visits');
    }
};
