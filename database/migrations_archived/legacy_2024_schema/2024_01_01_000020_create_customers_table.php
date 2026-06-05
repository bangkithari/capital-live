<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['individual', 'business'])->default('individual');

            // Individual fields
            $table->foreignId('title_id')->nullable()->constrained('title')->nullOnDelete();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->foreignId('suffix_id')->nullable()->constrained('suffix')->nullOnDelete();
            $table->foreignId('gender_id')->nullable()->constrained('gender')->nullOnDelete();
            $table->date('date_of_birth')->nullable();
            $table->string('ssn', 20)->nullable();

            // Business fields
            $table->string('business_name')->nullable();
            $table->string('dba')->nullable();
            $table->string('entity_type')->nullable();
            $table->string('tax_id', 20)->nullable();
            $table->date('date_of_establishment')->nullable();

            // Contact
            $table->string('email')->nullable();
            $table->string('email2')->nullable();
            $table->string('phone_home', 20)->nullable();
            $table->string('phone_work', 20)->nullable();
            $table->string('phone_cell', 20)->nullable();
            $table->string('phone_fax', 20)->nullable();
            $table->foreignId('preferred_contact_id')->nullable()->constrained('preferred_contact')->nullOnDelete();
            $table->foreignId('preferred_language_id')->nullable()->constrained('preferred_language')->nullOnDelete();

            // Personal
            $table->foreignId('marital_status_id')->nullable()->constrained('marital_status')->nullOnDelete();
            $table->string('occupation')->nullable();
            $table->string('industry')->nullable();

            // Lead info
            $table->foreignId('lead_source_id')->nullable()->constrained('lead_source')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
