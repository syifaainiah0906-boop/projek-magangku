<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('alumni_data', function (Blueprint $table) {
            $table->string('village')->nullable()->after('current_address');
        });
    }

    public function down(): void
    {
        Schema::table('alumni_data', function (Blueprint $table) {
            $table->dropColumn('village');
        });
    }
};

