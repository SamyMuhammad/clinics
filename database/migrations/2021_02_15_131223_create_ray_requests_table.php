<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRayRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ray_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreignId('patient_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('ray_type_id')->nullable();
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->foreignId('file_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');

            $table->foreign('doctor_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('ray_type_id')->references('id')->on('rays_types')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('technician_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('ray_request');
    }
}
