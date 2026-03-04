<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->unsignedBigInteger('memory_bytes')->after('cpu_cores')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->dropColumn('memory_bytes');
        });
    }
};
