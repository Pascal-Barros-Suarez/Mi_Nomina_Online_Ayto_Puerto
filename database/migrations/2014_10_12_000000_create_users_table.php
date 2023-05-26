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
            $table->tinyInteger('is_admin')->default(0)->nullable();
            $table->string('name');
            $table->string('dni')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->unique();
            $table->bigInteger('social_security_number')->unsigned()->default(0)->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable(); //cargo
            $table->date('hiring_date')->nullable(); //antiguedad
            $table->string('group')->nullable();
            $table->integer('level')->default(0)->nullable();
            $table->integer('cnae_93')->default(0)->nullable();
            $table->integer('contribution_group')->default(0)->nullable(); //grupo de cotizacion
            $table->string('type')->nullable();
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
