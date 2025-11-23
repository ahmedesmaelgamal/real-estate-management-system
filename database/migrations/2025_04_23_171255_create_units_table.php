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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('real_state_id')->constrained('real_state')->onDelete('cascade');
            $table->string('unit_number');
            $table->text('description')->nullable();
            $table->string('space');
            $table->string('unit_code');
            $table->string('unified_code')->nullable();
            $table->string('floor_count');
            $table->string('bathrooms_count');
            $table->string('bedrooms_count');
            $table->string('northern_border');
            $table->string('southern_border');
            $table->string('eastern_border');
            $table->string('western_border');
            $table->boolean('status')->default(0);
            $table->text('stop_reason')->nullable();
            $table->string('admin_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
