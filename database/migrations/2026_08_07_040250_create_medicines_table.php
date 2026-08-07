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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('category'); // e.g. Analgesic, Antibiotic
            $table->string('formulation'); // e.g. Tablet, Syrup
            $table->string('dosage_rule')->nullable(); // e.g. 3x1
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(10);
            $table->date('expire_date');
            $table->decimal('purchase_price', 12, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
