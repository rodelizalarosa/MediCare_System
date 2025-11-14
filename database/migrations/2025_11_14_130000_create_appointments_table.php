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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            // Staff assignment (doctor, midwife, etc.) – stored in users table
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('appointment_type', [
                'General Check-up',
                'Maternal Check-up',
                'Vaccination',
                'Doctor Consultation',
                'Midwife Consultation',
            ]);

            $table->date('appointment_date');
            $table->time('appointment_time');

            $table->enum('appointment_status', [
                'Pending',
                'Approved',
                'Rejected',
                'Completed',
                'Cancelled',
            ])->default('Pending');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

