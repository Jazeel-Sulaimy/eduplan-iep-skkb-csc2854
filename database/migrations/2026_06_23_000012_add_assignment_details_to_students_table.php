<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('review_frequency')->nullable()->after('counsellor_id');
            $table->text('assignment_notes')->nullable()->after('review_frequency');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['review_frequency', 'assignment_notes']);
        });
    }
};
