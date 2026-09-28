<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('counties')) {
            Schema::create('counties', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50);
                $table->string('crest_url', 500)->nullable();
                $table->index('name', 'idx_county_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counties');
    }
};
