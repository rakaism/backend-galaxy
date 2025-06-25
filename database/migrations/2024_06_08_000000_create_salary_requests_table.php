<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // Finance yang mengajukan
            $table->decimal('salary', 15, 2);
            $table->decimal('bonus', 15, 2)->default(0);
            $table->decimal('pph', 15, 2)->default(0);
            $table->decimal('total', 15, 2); // Gaji akhir setelah pajak
            $table->enum('status', ['pending', 'approved', 'rejected', 'paid'])->default('pending');
            $table->integer('approved_by')->nullable(); // Manager
            $table->timestamp('approved_at')->nullable();
            $table->integer('paid_by')->nullable(); // Finance yang memproses
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_proof')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('paid_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_requests');
    }
};