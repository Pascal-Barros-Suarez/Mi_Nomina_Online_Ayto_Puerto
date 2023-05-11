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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dni')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('num_seg_social')->default(0);
            $table->string('department');
            $table->string('cargo');
            $table->timestamp('antiguedad')->nullable();
            $table->string('grupo');
            $table->integer('nivel')->default(0);
            $table->integer('cnae_93')->default(0);
            $table->integer('grupo_cotizacion')->default(0);
            $table->string('tipo');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
