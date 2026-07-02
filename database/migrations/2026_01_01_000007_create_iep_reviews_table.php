<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('iep_reviews', function (Blueprint $table) {
            $table->id();

$table->foreignId('student_id')->constrained()->cascadeOnDelete();
$table->date('review_date');
$table->string('review_status')->default('Scheduled');
$table->text('review_notes');
$table->date('next_review_date')->nullable();
$table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iep_reviews');
    }
};
