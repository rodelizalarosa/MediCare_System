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
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['patient', 'staff', 'doctor', 'midwife'])->default('patient');

            // Email verification
            $table->tinyInteger('email_verified')->default(0);
            $table->string('verify_token', 255)->nullable();
            $table->string('verification_pin', 6)->nullable();
            $table->timestamp('pin_created_at')->nullable();

            $table->enum('status', ['Active', 'Pending', 'Disabled'])->default('Active');

            $table->rememberToken();
            $table->softDeletes();
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
