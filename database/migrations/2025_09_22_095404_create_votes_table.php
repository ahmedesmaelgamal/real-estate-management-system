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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("association_id")->constrained('associations')->cascadeOnDelete();
            $table->boolean("status")->default(1)->nullable();
            $table->integer("first_detail_id")->default(null)->nullable();
            $table->integer("second_detail_id")->default(null)->nullable();
            $table->integer("third_detail_id")->default(null)->nullable();
            $table->integer("vote_percentage")->default(0)->nullable();
            $table->integer("stage_number")->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
