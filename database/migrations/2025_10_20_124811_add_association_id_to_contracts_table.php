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
            $table->unsignedBigInteger('association_id')->nullable()->after('id');

            $table->foreign('association_id')
                ->references('id')
                ->on('associations')
                ->onDelete('cascade');

            $table->enum('contract_type', ['general', 'owners', 'association'])->after('association_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {

            $table->dropForeign(['association_id']);


            $table->dropColumn('association_id');
        });
    }
};
