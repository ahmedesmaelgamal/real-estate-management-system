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
        Schema::create("vote_details_has_users", function (Blueprint $table) {
            $table->id();

            // المستخدم الذي صوّت
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            
            $table->unsignedBigInteger("vote_id")->nullable();
            $table->foreign("vote_id")->references("id")->on("votes")->onDelete("cascade");

            // تفاصيل التصويت (المرحلة)
            $table->unsignedBigInteger("vote_detail_id")->nullable();
            $table->foreign("vote_detail_id")->references("id")->on("vote_details")->onDelete("cascade");

            // المرحلة
            $table->enum("stage_number", [1, 2, 3])->comment("the vote stage");

            // التصويت (نعم أو لا)
            $table->enum("vote_action", ["yes", "no"])->comment("the vote action result");

            // من الذي قام بالتصويت (المستخدم أو الأدمن)
            $table->enum("vote_creator", ["admin", "user"])->comment("who made the vote (user or admin)");

            // لو الأدمن هو اللي صوّت بدلاً من المستخدم
            $table->unsignedBigInteger("admin_id")->nullable()->comment("the admin who voted for the user");
            $table->foreign("admin_id")->references("id")->on("admins")->onDelete("set null");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("vote_details_has_users");
    }
};
