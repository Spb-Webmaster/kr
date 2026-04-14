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
        Schema::create('self_employeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // ID продавца
            $table->text('register_address')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('inn')->nullable(); // ИНН
            $table->string('passport_serial')->nullable(); // Паспорт Серия
            $table->string('passport_number')->nullable(); // Паспорт Номер
            $table->string('who_issued')->nullable(); // Кто выдал
            $table->string('date_issued')->nullable(); // Когда выдан
            $table->string('bank')->nullable(); // Название банка
            $table->string('bik')->nullable(); // БИК
            $table->string('correspondent_account')->nullable(); //корреспондентский счет
            $table->string('payment_account')->nullable(); // расчетный счет
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_employeds');
    }
};
