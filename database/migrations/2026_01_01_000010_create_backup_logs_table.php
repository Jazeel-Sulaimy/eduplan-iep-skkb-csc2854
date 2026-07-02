<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();

$table->dateTime('backup_date');
$table->string('backup_name');
$table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
$table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_logs');
    }
};
