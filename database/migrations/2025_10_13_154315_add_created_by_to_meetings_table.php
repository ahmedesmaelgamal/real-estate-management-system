<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            // Step 1: create nullable column
            $table->unsignedBigInteger('created_by')->nullable()->after('owner_id');
        });

        Schema::table('meetings', function (Blueprint $table) {
            // Step 2: add foreign key
            $table->foreign('created_by')
                  ->references('id')
                  ->on('admins')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};
