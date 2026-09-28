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
        if (!Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->integer('zip_code');
                $table->string('city', 50);
                $table->integer('id_county');
                $table->integer('population')->nullable();
                $table->index('zip_code', 'idx_zip_code');
                $table->index('city', 'idx_city');
                $table->index('id_county', 'idx_id_county');
            });
        }
    }
    
        /**
         * Reverse the migrations.
         */
        public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
