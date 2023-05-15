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
            $table->string('social_security_number')->default('')->nullable();
            //$table->bigInteger('social_security_number')->default(0)->unsigned();
            //$table->decimal('social_security_number', 20, 0)->default(0);
            $table->string('department');
            $table->string('position');//cargo
            $table->date('hiring_date')->nullable(); //antiguedad
            $table->string('group');
            $table->integer('level')->default(0);
            $table->integer('cnae_93')->default(0);
            $table->integer('contribution_group')->default(0); //grupo de cotizacion
            $table->string('type');
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
