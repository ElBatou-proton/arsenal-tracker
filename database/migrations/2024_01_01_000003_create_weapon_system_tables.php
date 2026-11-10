<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('abbreviation')->unique();
            $table->integer('order')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('weapon_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('weapon_assignment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->foreignId('rank_id')->nullable()->constrained('ranks')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('serial_number')->unique();
            $table->string('qr_code')->nullable()->unique()->index();
            $table->foreignId('owner_id')->nullable()->constrained('owners')->cascadeOnDelete();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('caliber')->nullable();
            $table->string('origin')->nullable();
            $table->string('chamber_length')->nullable();
            $table->time('intake_time')->nullable();
            $table->date('intake_date')->nullable();
            $table->foreignId('weapon_type_id')->nullable()->constrained('weapon_types')->nullOnDelete();
        });

        Schema::create('weapon_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weapon_id')->constrained('weapons')->cascadeOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('owners')->nullOnDelete();
            $table->string('assigned_by')->nullable();
            $table->dateTime('entry_date')->nullable();
            $table->string('reason');
            $table->text('details')->nullable();
            $table->string('destination')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('weapon_assignment_statuses')->restrictOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('weapon_assignments');
        Schema::dropIfExists('weapons');
        Schema::dropIfExists('owners');
        Schema::dropIfExists('weapon_assignment_statuses');
        Schema::dropIfExists('weapon_types');
        Schema::dropIfExists('ranks');
    }
};