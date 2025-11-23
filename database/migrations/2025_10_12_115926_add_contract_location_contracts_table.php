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
        Schema::table('contracts', function (Blueprint $table) {
            if (Schema::hasColumn('contracts', 'contract_location_id')) {
                $table->foreignId('contract_location_id')
                    ->nullable()
                    ->change();
            }

            if (!Schema::hasColumn('contracts', 'contract_location')) {
                $table->string('contract_location')->nullable()->after('contract_location_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            if (Schema::hasColumn('contracts', 'contract_location')) {
                $table->dropColumn('contract_location');
            }
        });
    }
};
