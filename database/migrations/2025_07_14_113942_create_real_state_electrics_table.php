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
        Schema::create('real_state_electrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('real_state_id')->constrained('real_state')->cascadeOnDelete();
            $table->string('electric_account_number')->nullable();
            $table->string('electric_meter_number')->nullable();
            $table->string('electric_subscription_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('real_state_electrics');
    }
};
