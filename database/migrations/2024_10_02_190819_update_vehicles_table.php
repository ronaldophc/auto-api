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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('fuel_type')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->string('steering_type')->nullable()->change();
            $table->string('transmission')->nullable()->change();
            $table->string('manufacture_year')->nullable()->change();
            $table->string('model_year')->nullable()->change();
            $table->string('current_km')->nullable()->change();
            $table->string('is_new')->nullable()->default(false)->change();
            $table->string('is_featured')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('fuel_type')->nullable(false)->change();
            $table->string('color')->nullable(false)->change();
            $table->string('steering_type')->nullable(false)->change();
            $table->string('transmission')->nullable(false)->change();
            $table->year('manufacture_year')->nullable(false)->change();
            $table->year('model_year')->nullable(false)->change();
            $table->integer('current_km')->nullable(false)->change();
            $table->boolean('is_new')->nullable(false)->default(false)->change();
            $table->boolean('is_featured')->nullable(false)->unique(false)->change();
        });
    }
};
