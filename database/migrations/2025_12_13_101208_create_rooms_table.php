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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number');
            $table->date('date');
            $table->timestamp('call_at')->nullable();
            $table->timestamp('finish_at')->nullable();
            $table->enum('status', ['WAITING', 'CALLED', 'SERVED', 'COMPLETED', 'MISSED'])->default('WAITING');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
