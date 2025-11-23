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
        Schema::table('meetings', function (Blueprint $table) {
            if (Schema::hasColumn('meetings', 'agenda_id')) {
                $table->dropForeign(['agenda_id']);
                $table->dropColumn('agenda_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->foreignId('agenda_id')->nullable()->constrained('agendas')->onDelete('cascade');
        });
    }
};
