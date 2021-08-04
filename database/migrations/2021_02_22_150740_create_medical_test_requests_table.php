<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalTestRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_test_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreignId('patient_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('medical_test_id')->nullable();
            $table->unsignedBigInteger('tests_responsible_id')->nullable();
            $table->foreignId('file_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');

            $table->foreign('doctor_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('medical_test_id')->references('id')->on('medical_tests')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tests_responsible_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('medical_test_requests');
    }
}
