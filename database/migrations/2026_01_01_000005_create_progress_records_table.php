<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('progress_records', function (Blueprint $table) {
            $table->id();

$table->foreignId('student_id')->constrained()->cascadeOnDelete();
$table->date('progress_date');
$table->string('progress_status');
$table->text('progress_notes');
$table->integer('positive_updates')->default(0);
$table->integer('need_monitoring')->default(0);
$table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_records');
    }
};
