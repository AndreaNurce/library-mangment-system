<?php

use App\Enums\GenderEnum;
use App\Enums\StatusEnum;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('lastname');
            $table->string('password');
            $table->string('email')->unique();
            $table->enum('gender', GenderEnum::toArray())->default(GenderEnum::default());
            $table->date('birthdate');
            $table->enum('role', UserRoleEnum::toArray())->default(UserRoleEnum::default());
            $table->boolean('is_banned');
            $table->enum('status', [StatusEnum::toArray()])->default(StatusEnum::default());
            $table->timestamp('email_verified_at')->nullable();
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
};
