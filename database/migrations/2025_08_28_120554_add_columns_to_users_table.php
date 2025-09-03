<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->unique()->nullable();
            $table->string('prodi')->nullable();
            $table->string('kelas')->nullable();
            $table->string('jenis_beasiswa')->nullable();
            $table->string('role')->default('user'); // Menambahkan role default
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'prodi', 'kelas', 'jenis_beasiswa', 'role']);
        });
    }
};
