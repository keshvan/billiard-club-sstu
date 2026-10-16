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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billiard_table_id')
                ->constrained('billiard_tables', 'id')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'id')
                ->nullOnDelete();

            $table->string('guest_name')->nullable();
            $table->string('guest_phone', 32)->nullable();
            $table->string('guest_email')->nullable();

            $table->dateTime('starts_at');
            $table->dateTime('ends_at');

            $table->string('status', 20)->default('pending');
            $table->dateTime('expires_at')->nullable(); //сколько держит pending
            $table->dateTime('confirmed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();

            $table->decimal('total_price', 10, 2)->default(0);

            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
