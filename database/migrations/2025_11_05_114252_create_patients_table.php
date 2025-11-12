<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key to users table
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            
            $table->enum('sex', ['Male', 'Female', 'Other']);
            $table->date('birth_date');
            
            $table->enum('civil_status', ['Single','Married','Widowed','Separated'])->default('Single');
            $table->text('address');
            $table->string('contact_number', 20)->nullable();

            $table->string('emergency_contact_name', 100)->nullable();
            $table->string('emergency_contact_number', 20)->nullable();
            $table->string('relationship_to_patient', 50)->nullable();

            $table->enum('registration_source', ['Clinic','Online'])->default('Online');
            $table->unsignedBigInteger('created_by_staff')->nullable();
            $table->enum('record_status', ['Active','Archived'])->default('Active');

            $table->timestamps(); // created_at and updated_at

            $table->index(['first_name', 'last_name', 'birth_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
