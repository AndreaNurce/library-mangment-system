<?php

use App\Enums\LoanRequestStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('book_id')->references('id')->on('books')->cascadeOnDelete();
            $table->timestamp('requested_at');
            $table->enum('book_loan_status', LoanRequestStatusEnum::toArray())->default(LoanRequestStatusEnum::default());
            $table->date('loan_date');
            $table->date('return_date')->nullable();
            $table->integer('number_copies')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
