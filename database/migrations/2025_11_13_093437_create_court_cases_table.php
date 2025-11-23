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
        Schema::create('court_cases', function (Blueprint $table) {
            $table->id();
            $table->integer("case_number");
            $table->foreignId("case_type_id")->constrained("case_types")->cascadeOnDelete();
            $table->foreignId("judiciaty_type_id")->constrained("judiciaty_types")->cascadeOnDelete();
            $table->foreignId("association_id")->constrained("associations")->cascadeOnDelete();
            $table->foreignId("owner_id")->constrained("users")->cascadeOnDelete();
            $table->foreignId("unit_id")->constrained("units")->cascadeOnDelete();
            $table->date("case_date");
            $table->boolean("status")->default(1)->nullable();
            $table->date("judiciaty_date");
            $table->decimal("case_price" , 8);
            $table->string("topic");
            $table->text("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('court_cases');
    }
};
