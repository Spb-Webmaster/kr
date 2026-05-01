<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('file1')->nullable()->after('about_me');
            $table->string('file2')->nullable()->after('file1');
            $table->string('file3')->nullable()->after('file2');
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['file1', 'file2', 'file3']);
        });
    }
};
