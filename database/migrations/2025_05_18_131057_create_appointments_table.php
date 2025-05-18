<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained(); // client
        $table->foreignId('staff_id')->constrained('users');
        $table->foreignId('service_id')->constrained();
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
