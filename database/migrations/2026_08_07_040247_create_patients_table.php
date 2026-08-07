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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('patient_type')->default('Umum'); // Murid, Pegawai, Keluarga Pegawai, Forsipa, Umum
            $table->string('patient_code')->unique(); // e.g. A298826
            $table->date('date_of_birth');
            $table->string('gender'); // Male / Female
            $table->string('phone');
            $table->text('address');
            $table->text('allergies')->nullable();
            $table->text('medical_history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
