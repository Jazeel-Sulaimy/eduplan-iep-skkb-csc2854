<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

$table->foreignId('student_id')->constrained()->cascadeOnDelete();
$table->string('case_title');
$table->string('priority')->default('Medium');
$table->text('consultation_notes')->nullable();
$table->text('support_plan')->nullable();
$table->string('support_type')->nullable();
$table->date('review_date')->nullable();
$table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
$table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
