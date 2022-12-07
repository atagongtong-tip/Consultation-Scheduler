<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type')->nullable(); // Chat Consultation, Video Platform
            $table->integer('conversation_id')->nullable();
            $table->longText('meeting_url')->nullable();
            $table->dateTime('start_schedule')->nullable();
            $table->dateTime('end_schedule')->nullable();
            $table->longText('subject')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->default('Pending'); // Pending, Approved, Completed, Cancelled, Expired
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
