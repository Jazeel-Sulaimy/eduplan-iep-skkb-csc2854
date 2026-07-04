<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('behaviour_records', function (Blueprint $table) {
            $table->string('reward_rule')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('behaviour_records', function (Blueprint $table) {
            $table->dropColumn('reward_rule');
        });
    }
};
