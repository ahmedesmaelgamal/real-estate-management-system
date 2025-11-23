<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->enum('contract_type', [
                'general',
                'owners_with_partner',
                'owners_with_owner',
                "owners",
                'association'
            ])->default('general')->change();
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->enum('contract_type', [
                'general',
                'owners',
                'association'
            ])->default('general')->change();
        });
    }
};
