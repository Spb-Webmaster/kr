<?php

use App\Enum\CertificateStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_papers', function (Blueprint $table) {
            $table->string('certificate_status')
                ->default(CertificateStatus::Unused->value)
                ->after('price_option');
        });
    }

    public function down(): void
    {
        Schema::table('order_papers', function (Blueprint $table) {
            $table->dropColumn('certificate_status');
        });
    }
};
