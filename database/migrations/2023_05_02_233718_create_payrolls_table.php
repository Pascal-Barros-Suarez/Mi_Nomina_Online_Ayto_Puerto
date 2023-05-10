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
            $table->intenger('sueldo_bruto');
            $table->intenger('sueldo_base');
            $table->intenger('irpf');
            $table->intenger('complementos');

            $table->string('concepto');

            $table->timestamps();
            //$table->string('name');
            //$table->string('path');
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
