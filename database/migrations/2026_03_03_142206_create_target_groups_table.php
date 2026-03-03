<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('arn')->unique();
            $table->string('vpc')->index();
            $table->string('protocol');
            $table->unsignedSmallInteger('port');
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_groups');
    }
};
