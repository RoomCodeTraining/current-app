<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function generateShortCode(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $code;
    }

    public function up(): void
    {
        Schema::table('digital_cards', function (Blueprint $table) {
            $table->string('short_code', 8)->nullable()->unique()->after('slug');
        });

        $existing = \DB::table('digital_cards')->get();
        $used = [];
        foreach ($existing as $row) {
            do {
                $code = $this->generateShortCode();
            } while (in_array($code, $used, true));
            $used[] = $code;
            \DB::table('digital_cards')->where('id', $row->id)->update(['short_code' => $code]);
        }
    }

    public function down(): void
    {
        Schema::table('digital_cards', function (Blueprint $table) {
            $table->dropColumn('short_code');
        });
    }
};
