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
        Schema::create('case_updates', function (Blueprint $table) {
            $table->id();

            $table->json('title');

            $table->foreignId("court_cases_id")->constrained("court_cases")->cascadeOnDelete();
            $table->foreignId("case_update_type_id")->constrained("case_update_types")->cascadeOnDelete();

            $table->unsignedBigInteger('creator_id')->nullable();
            $table->string('creator_type')->nullable();

            $table->date('end_date')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_updates');
    }
};
