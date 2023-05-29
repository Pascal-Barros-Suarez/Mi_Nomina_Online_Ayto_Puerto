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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('gross_salary');
            $table->integer('base_salary');
            $table->integer('income_tax'); // IRPF
            $table->integer('destination_allowance')->nullable(); // Complemento destino
            $table->integer('specific_allowance')->nullable(); // Complemento específico
            $table->integer('specific_complement')->nullable(); // Complemento específico
            $table->integer('commission_attendance')->nullable(); // Asistencia a comisiones
            $table->integer('common_contingencies')->nullable(); // Contingencias comunes
            $table->integer('unemployment')->nullable(); // Desempleo
            $table->integer('mei')->nullable(); // MEI
            $table->integer('professional_training')->nullable(); // Formación Profesional
            $table->integer('csic')->nullable(); // CSIC
            $table->string('concept');
            $table->string('month'); // campo mes
            $table->integer('year'); // campo año

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
