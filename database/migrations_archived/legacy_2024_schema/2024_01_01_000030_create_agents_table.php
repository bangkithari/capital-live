<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('npi_number', 20)->nullable();
            $table->string('license_number', 50)->nullable();
            $table->foreignId('license_status_id')->nullable()->constrained('license_status')->nullOnDelete();
            $table->foreignId('license_type_id')->nullable()->constrained('license_type')->nullOnDelete();
            $table->date('license_effective_date')->nullable();
            $table->date('license_expiration_date')->nullable();
            $table->foreignId('state_id')->nullable()->constrained('state')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
