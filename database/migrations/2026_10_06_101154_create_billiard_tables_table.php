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
        Schema::create('billiard_tables', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hall_id')
                ->constrained('halls', 'id')
                ->restrictOnDelete();

            $table->foreignId('game_type_id')
                ->constrained('game_types', 'id')
                ->restrictOnDelete();

            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['hall_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billiard_tables');
    }
};
