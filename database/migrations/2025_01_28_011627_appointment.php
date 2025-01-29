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
        // Crear la tabla appointments
        Schema::create('appointment', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->date('date');
            $blueprint->time('time');
            $blueprint->string('description');
            $blueprint->unsignedBigInteger('user_id'); // Definir user_id como unsignedBigInteger
            $blueprint->enum('status', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');
            $blueprint->timestamps();


            $blueprint->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la tabla appointments
        Schema::dropIfExists('appointment');
    }
};
