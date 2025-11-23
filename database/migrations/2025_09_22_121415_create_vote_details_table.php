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
        Schema::create('vote_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("vote_id")->constrained("votes")->cascadeOnDelete();
            $table->timestamp("start_date")->nullable();
            $table->timestamp("end_date")->nullable();
            $table->integer("yes_audience")->default(0)->nullable();
            $table->integer("no_audience")->default(0)->nullable();
            $table->integer("vote_percentage")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vote_details');
    }
};
