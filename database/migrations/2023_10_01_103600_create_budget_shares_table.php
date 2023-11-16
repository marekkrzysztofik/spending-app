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
        Schema::create('budget_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_user_id');
            $table->foreign('owner_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('shared_user_id');
            $table->foreign('shared_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('budget_id');
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_shares');
    }
};
