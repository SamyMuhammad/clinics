<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('photo')->default('assets/images/default-profile-photo.jpg');
            $table->enum('job', User::getEnumValues('job'))->index()->default('doctor');
            $table->string('address')->nullable();
            $table->decimal('salary', 10, 2);
            $table->string('contract_period')->default('1 year');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
