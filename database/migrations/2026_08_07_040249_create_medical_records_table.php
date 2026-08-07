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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->date('appointment_date');
            $table->string('appointment_time')->nullable();
            $table->text('complaints');
            $table->text('physical_check')->nullable();
            $table->string('diagnosis'); // ICD-10
            $table->string('action_taken')->nullable();
            $table->text('prescription_notes')->nullable();
            $table->string('disease')->nullable(); // For dashboard matching (e.g. Fever, Cold)
            $table->string('status')->default('Draft'); // Draft or Closed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
