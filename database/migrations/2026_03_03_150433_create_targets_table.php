<?php

use App\Models\TargetGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TargetGroup::class)->constrained()->cascadeOnDelete();
            $table->string('instance');
            $table->string('state')->index();
            $table->timestamps();

            $table->unique(['instance', 'target_group_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};
