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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('game_type_id')
                ->constrained('game_types', 'id')
                ->restrictOnDelete();

            $table->foreignId('hall_id')
                ->constrained('halls', 'id')
                ->restrictOnDelete();

            $table->string('name');
            $table->tinyInteger('day_of_week')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('price_per_hour', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
