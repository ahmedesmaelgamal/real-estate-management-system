<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->time('date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->timestamp('date')->nullable()->change();
        });
    }
};
