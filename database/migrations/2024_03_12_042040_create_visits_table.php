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
            $table->integer('store_id');
            $table->string('store_name');
            $table->string('store_type');
            $table->string('note')->nullable();
            $table->string('image');
            $table->date('in_date');
            $table->time('in_time');
            $table->string('in_lat');
            $table->string('in_long');
            $table->date('out_date');
            $table->time('out_time');
            $table->string('out_lat');
            $table->string('out_long');
            $table->json('user_login');
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
