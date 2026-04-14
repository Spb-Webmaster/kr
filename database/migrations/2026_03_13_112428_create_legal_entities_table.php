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
        Schema::create('legal_entities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // ID продавца
            $table->string('name');
            $table->string('full_name')->nullable();
            $table->text('legal_address')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('inn')->nullable(); // ИНН
            $table->string('kpp')->nullable(); // КПП
            $table->string('ogrn')->nullable(); // ОГРН
            $table->string('director')->nullable(); // Руководитель
            $table->string('accountant')->nullable(); // бухгалтер
            $table->string('person_contract')->nullable(); //Лицо, уполномоченное подписывать договоры по доверенности
            $table->string('bank')->nullable(); // Название банка
            $table->string('bik')->nullable(); // БИК
            $table->string('correspondent_account')->nullable(); //корреспондентский счет
            $table->string('payment_account')->nullable(); // расчетный счет
            $table->string('okved')->nullable(); // ОКВЭД
            $table->enum('payment_nds', ['presence', 'absence'])->default('absence'); // Уплата НДС (наличие / отсутствие)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_entities');
    }
};
