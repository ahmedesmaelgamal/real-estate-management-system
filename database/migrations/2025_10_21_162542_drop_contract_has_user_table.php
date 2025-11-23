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
        Schema::dropIfExists('contract_has_user');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('contract_has_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('contract_id')->nullable();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');

            $table->timestamps();
        });
    }
};
