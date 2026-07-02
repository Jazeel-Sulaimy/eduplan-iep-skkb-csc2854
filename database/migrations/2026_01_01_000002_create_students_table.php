<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('school_code')->default('TBA 5001');
            $table->string('school_name')->default('Sekolah Kebangsaan Kuala Berang');
            $table->string('student_name');
            $table->string('student_ic')->nullable();
            $table->string('class_name');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('category')->nullable();
            $table->string('programme_type')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('existing_knowledge')->nullable();
            $table->text('student_ability')->nullable();
            $table->text('address')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_email')->nullable();
            $table->foreignId('parent_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('counsellor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
