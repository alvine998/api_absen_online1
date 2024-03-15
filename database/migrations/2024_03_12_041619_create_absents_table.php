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
        Schema::create('absents', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->string('store_name');
            $table->date('date');
            $table->time('time');
            $table->enum('type', ['in', 'out']);
            $table->string('image');
            $table->string('latt');
            $table->string('long');
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
        Schema::dropIfExists('absents');
    }
};
