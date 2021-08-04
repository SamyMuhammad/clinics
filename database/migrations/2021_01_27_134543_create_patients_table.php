<?php

use App\Models\Patient;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Any changes to the 'enum' columns-values must be done in the model.
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('ar_name');
            $table->string('en_name');
            $table->string('phone')->unique();
            $table->unsignedBigInteger('national_id')->nullable()->unique();
            $table->string('nationality');
            $table->unsignedTinyInteger('age');
            $table->enum('gender', Patient::getEnumValues('gender'));
            $table->enum('social_status', Patient::getEnumValues('social_status'));
            $table->string('address')->nullable();
            $table->enum('type', Patient::getEnumValues('type'))->default('citizen');
            $table->enum('payment_method', Patient::getEnumValues('payment_method'))->default('cash');
            $table->enum('status', Patient::getEnumValues('status'))->default('opened');
            $table->boolean('is_emergency')->default(false);
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
        Schema::dropIfExists('patients');
    }
}
