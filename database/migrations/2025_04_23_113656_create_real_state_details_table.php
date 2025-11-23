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
        Schema::create('real_state_details', function (Blueprint $table) {
            $table->id()    ;
            $table->foreignId('real_state_id')->constrained('real_state')->cascadeOnDelete();

            $table->string("street");
            $table->string("space")->comment('مساحه');
            $table->string("flat_space")->comment('مساحة المسطحات');
            $table->string("part_number");

            $table->string("bank_account_number");
            $table->string("mint_number");
            $table->string("mint_source");

            $table->string("floor_count");
            $table->string("elevator_count");




            $table->string("northern_border");
            $table->string("southern_border");
            $table->string("eastern_border");
            $table->string("western_border");
//            $table->integer("area");
            $table->date("building_year");
//            $table->integer("building_count");
            $table->string("building_type");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_state_details');
    }
};
