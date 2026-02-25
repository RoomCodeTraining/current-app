<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_cards', function (Blueprint $table) {
            $table->string('edit_code', 20)->nullable()->after('avatar_path');
        });
    }

    public function down(): void
    {
        Schema::table('digital_cards', function (Blueprint $table) {
            $table->dropColumn('edit_code');
        });
    }
};
