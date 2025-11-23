<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('real_state_waters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('real_state_id')->constrained('real_state')->cascadeOnDelete();
            $table->string("water_account_number");
            $table->string("water_meter_number");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_state_waters');
    }
};
