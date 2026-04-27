<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('path_settings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedInteger('capacity');
            $table->boolean('is_active')->default(true);
            $table->boolean('close_when_full')->default(true);
            $table->timestamps();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('path_code', 10)->index();
            $table->string('full_name');
            $table->string('nisn', 10)->unique();
            $table->string('nik', 16)->nullable();
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('gender', 2);
            $table->string('address', 500);
            $table->string('village', 150)->nullable();
            $table->string('district', 150)->nullable();
            $table->string('previous_school');
            $table->string('parent_name');
            $table->string('parent_phone', 20);
            $table->string('email')->nullable();
            $table->string('status', 40)->index();
            $table->string('admin_note', 500)->nullable();
            $table->timestamp('submitted_at')->index();
            $table->json('special_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('path_settings');
    }
};
