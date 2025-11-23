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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('association_id')->constrained()->onDelete('cascade');
            $table->foreignId('agenda_id')->constrained()->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('admins')->onDelete('cascade');
            // $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->dateTime('date');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');

    }
};
