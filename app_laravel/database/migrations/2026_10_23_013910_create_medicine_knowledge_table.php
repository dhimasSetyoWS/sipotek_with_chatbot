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
        Schema::create('medicine_knowledge', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')
                ->unique()
                ->constrained('medicines')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->text('indications')->nullable();
            $table->text('contraindications')->nullable();
            $table->text('warnings')->nullable();
            $table->text('side_effects')->nullable();

            $table->string('source_name')->nullable();
            $table->text('source_url')->nullable();

            $table->enum('status', ['draft', 'reviewed'])
                ->default('draft');

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_knowledge');
    }
};
