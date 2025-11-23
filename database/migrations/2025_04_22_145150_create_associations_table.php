<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            // $table->bigInteger('unit_count')->nullable();
            // $table->bigInteger('real_state_count')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('establish_date');
            $table->date('due_date');
            $table->string( 'unified_number');
            $table->string('establish_number');
            $table->boolean('status')->nullable()->comment('active and inactive');
            $table->string('interception_reason')->nullable()->comment('(سبب الإيقاف) enter if status is 0');
            $table->foreignId('association_manager_id')->constrained('admins')->cascadeOnDelete();
            $table->date('appointment_start_date')->nullable();
            $table->string('association_model_id')->nullable()->constrained('association_models')->nullOnDelete();
            $table->date('appointment_end_date')->nullable();
            $table->double('monthly_fees')->nullable();
            $table->boolean('is_commission')->default(0)->comment(' (عمولات إضافيه)   0 => no commission, 1 => commission');
            $table->string('commission_name')->nullable()->comment(' (اسم العموله)  enter if is_commission = 1');
            $table->boolean('commission_type')->nullable()->comment('0 -> نسبه مئويه <- 1 , قيمه ثابته');
            $table->integer('commission_percentage')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('logo')->nullable();
            $table->integer('admin_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
