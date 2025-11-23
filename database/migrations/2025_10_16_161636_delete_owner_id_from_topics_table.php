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
        Schema::table('topics', function (Blueprint $table) {
            if (Schema::hasColumn('topics', 'owner_id')) {
                $table->dropColumn('owner_id');
            }

            if (Schema::hasColumn('topics', 'description')) {
                $table->dropColumn('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            if (!Schema::hasColumn('topics', 'owner_id')) {
                $table->unsignedBigInteger('owner_id')->nullable();
            }

            if (!Schema::hasColumn('topics', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }
};
