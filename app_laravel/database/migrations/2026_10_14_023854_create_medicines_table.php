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
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('name', 150);
            $table->string('brand', 100)->nullable();
            $table->text('active_ingredients')->nullable(); // kandungan zat aktif
            $table->string('strength', 50)->nullable();     // contoh: 500mg, 250mg/5ml
            $table->string('dosage_form', 50);              // tablet, sirup, kapsul, dll
            $table->string('registration_number', 50)->unique(); // nomor BPOM/izin edar
            $table->enum('classification', [
                'bebas',
                'bebas_terbatas',
                'keras',
                'narkotika',
                'psikotropika',
                'jamu',
                'herbal',
            ])->default('bebas');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('name');
            $table->index('brand');
            $table->index('classification');
            $table->index('is_active');
            $table->index(['category_id', 'is_active']);
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
