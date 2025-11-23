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
        Schema::create('contract_party_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("contract_id")->constrained("contracts")->cascadeOnDelete();
            $table->string("party_name");
            $table->string("party_nation_id");
            $table->string("party_phone");
            $table->string("party_email");
            $table->string("party_address");
            $table->enum('party_type', ['first', 'second']);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_party_details');
    }
};
