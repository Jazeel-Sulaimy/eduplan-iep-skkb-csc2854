<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('iep_goals', function (Blueprint $table) {
            $table->id();

$table->foreignId('student_id')->constrained()->cascadeOnDelete();
$table->string('curriculum_followed')->nullable();
$table->string('iep_focus')->nullable();
$table->text('main_challenges')->nullable();
$table->text('long_term_goals');
$table->text('short_term_goals');
$table->text('intervention_strategy')->nullable();
$table->text('achievement')->nullable();
$table->date('start_date')->nullable();
$table->date('review_date')->nullable();
$table->string('status')->default('In Progress');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iep_goals');
    }
};
