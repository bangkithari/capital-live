<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('carrier_id')->nullable()->constrained('carrier')->nullOnDelete();
            $table->foreignId('policy_type_id')->nullable()->constrained('policy_type')->nullOnDelete();
            $table->foreignId('policy_status_id')->nullable()->constrained('policy_status')->nullOnDelete();
            $table->string('policy_number')->nullable();
            $table->string('plan_name')->nullable();
            $table->decimal('premium', 12, 2)->nullable();
            $table->foreignId('payment_mode_id')->nullable()->constrained('payment_mode')->nullOnDelete();
            $table->decimal('face_amount', 15, 2)->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
