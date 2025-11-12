<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_history', function (Blueprint $table) {
            $table->id('history_id');

            // Foreign key to patients table
            $table->foreignId('patient_id')
                  ->constrained('patients')
                  ->onDelete('cascade');

            $table->text('known_conditions')->nullable();
            $table->text('allergies')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('previous_hospitalization')->nullable();
            $table->text('family_history')->nullable();

            $table->enum('immunization_status', ['Complete', 'Incomplete'])
                  ->default('Incomplete');

            $table->text('remarks')->nullable();

            $table->timestamp('last_updated')
                  ->useCurrent()
                  ->useCurrentOnUpdate();

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_history');
    }
};
