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
        Schema::create('medicine_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')
                ->constrained('medicines')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('batch_number', 50);
            $table->integer('stock_quantity')->default(0);
            $table->date('expiry_date');
            $table->timestamps();

            // batch_number unik per medicine
            $table->unique(['medicine_id', 'batch_number']);
            $table->index('expiry_date');
            $table->index(['medicine_id', 'expiry_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_batches');
    }
};
