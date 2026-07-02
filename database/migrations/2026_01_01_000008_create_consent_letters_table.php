<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consent_letters', function (Blueprint $table) {
            $table->id();

$table->foreignId('student_id')->constrained()->cascadeOnDelete();
$table->string('parent_name');
$table->string('parent_ic');
$table->string('student_ic')->nullable();
$table->date('consent_date');
$table->text('agreement_text')->nullable();
$table->string('status')->default('Approved');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consent_letters');
    }
};
