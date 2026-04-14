<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('date_birthday')->nullable();
            $table->text('about_me')->nullable();
            $table->string('telegram')->nullable();
            $table->string('max')->nullable();
            $table->string('website')->nullable();
            $table->string('vk')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('published')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
