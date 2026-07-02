<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('behaviour_records', function (Blueprint $table) {
            $table->id();

$table->foreignId('student_id')->constrained()->cascadeOnDelete();
$table->date('record_date');
$table->string('behaviour_type');
$table->text('description');
$table->integer('points')->default(0);
$table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('behaviour_records');
    }
};
