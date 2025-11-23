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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("contract_type_id")->constrained("contract_types")->cascadeOnDelete();
            $table->foreignId("contract_name_id")->constrained("contract_names")->cascadeOnDelete();
            $table->foreignId("contract_location_id")->constrained("contract_locations")->cascadeOnDelete();
            $table->foreignId("contract_first_party_id")->constrained("contract_parties")->cascadeOnDelete();
            $table->foreignId("contract_second_party_id")->constrained("contract_parties")->cascadeOnDelete();
            $table->date("date");
            $table->string("introduction");
            $table->string("contract_address");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
