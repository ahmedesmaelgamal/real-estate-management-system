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
        Schema::table('vote_details_has_users', function (Blueprint $table) {
            $table->string('file')->nullable()->after('vote_detail_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vote_details_has_users', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
