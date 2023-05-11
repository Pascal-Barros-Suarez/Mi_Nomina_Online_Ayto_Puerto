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
            $table->unsignedBigInteger('id_usuario');
            $table->integer('sueldo_bruto');
            $table->integer('sueldo_base');
            $table->integer('irpf');
            $table->integer('complementos');
            $table->string('concepto');
            $table->timestamps();
            //$table->string('name');
            //$table->string('path');

            $table->foreign('id_usuario')
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
