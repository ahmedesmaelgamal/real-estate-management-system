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
        Schema::create('real_state', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('real_state_number');
            $table->foreignId('association_id')->constrained('associations')->cascadeOnDelete();
            $table->boolean('status')->default(0);
            $table->string("lat");
            $table->string("long");
            $table->text("stop_reason")->nullable();
            $table->integer('admin_id')->nullable();
            $table->foreignId('legal_ownership_id')->nullable()->constrained('legal_ownerships')->nullOnDelete();
            $table->text('legal_ownership_other')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_state');
    }
};
