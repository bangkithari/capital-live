<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Appointment Status
        Schema::create('appointment_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Task Status
        Schema::create('task_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Source Type
        Schema::create('source_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Gender
        Schema::create('gender', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Title (Mr, Mrs, etc)
        Schema::create('title', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Marital Status
        Schema::create('marital_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Suffix
        Schema::create('suffix', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Preferred Contact
        Schema::create('preferred_contact', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Preferred Language
        Schema::create('preferred_language', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Address Type
        Schema::create('address_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // License Status
        Schema::create('license_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // License Type
        Schema::create('license_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Carrier
        Schema::create('carrier', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Policy Status
        Schema::create('policy_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Policy Type
        Schema::create('policy_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Payment Mode
        Schema::create('payment_mode', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Relationship
        Schema::create('relationship', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // State
        Schema::create('state', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->timestamps();
        });

        // Lead Source
        Schema::create('lead_source', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_source');
        Schema::dropIfExists('state');
        Schema::dropIfExists('relationship');
        Schema::dropIfExists('payment_mode');
        Schema::dropIfExists('policy_type');
        Schema::dropIfExists('policy_status');
        Schema::dropIfExists('carrier');
        Schema::dropIfExists('license_type');
        Schema::dropIfExists('license_status');
        Schema::dropIfExists('address_type');
        Schema::dropIfExists('preferred_language');
        Schema::dropIfExists('preferred_contact');
        Schema::dropIfExists('suffix');
        Schema::dropIfExists('marital_status');
        Schema::dropIfExists('title');
        Schema::dropIfExists('gender');
        Schema::dropIfExists('source_type');
        Schema::dropIfExists('task_status');
        Schema::dropIfExists('appointment_status');
    }
};
