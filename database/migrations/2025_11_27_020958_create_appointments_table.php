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
        $table->unsignedBigInteger('patient_id'); // user id dengan role patient
        $table->unsignedBigInteger('doctor_id');  // doctor table
        $table->date('appointment_date');
        $table->string('time_range'); // contoh: "08:00 - 12:00"
        $table->enum('status', ['pending', 'in-progress', 'completed', 'cancelled'])
              ->default('pending');
        $table->timestamps();

        $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
    });
}

}
