<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contract_party_details', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id')->nullable()->after('contract_id');
            $table->string('model_type')->nullable()->after('model_id');
        });
    }

    public function down(): void
    {
        Schema::table('contract_party_details', function (Blueprint $table) {
            $table->dropColumn(['model_id', 'model_type']);
        });
    }
};
