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
        Schema::create('meet_has_agenda', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meeting_id')->constrained('meetings')->onDelete('cascade');
            $table->foreignId('agenda_id')->constrained('agendas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meet_has_agenda');
    }
};
