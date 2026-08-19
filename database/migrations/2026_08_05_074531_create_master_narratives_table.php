<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_narratives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('core_topic');
            $table->text('master_content')->nullable();
            $table->text('core_summary')->nullable();
            $table->text('world_rules');
            $table->text('system_prompt');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('master_narratives');
    }
};
