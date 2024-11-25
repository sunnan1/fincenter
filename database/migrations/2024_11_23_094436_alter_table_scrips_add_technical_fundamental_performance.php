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
        Schema::table('scrip_data', function (Blueprint $table) {
            $table->float('change_per')->nullable();
        });

        Schema::table('scrips', function (Blueprint $table) {
            $table->string('symbol')->nullable();
            $table->decimal('fundamental_beta' , 8, 3)->nullable();
            $table->decimal('fundamental_market_cap' , 15, 3)->nullable();
            $table->decimal('fundamental_ratio' , 8, 3)->nullable();
            $table->string('fundamental_revenue')->nullable();
            $table->decimal('performance_3_year' , 8, 3)->nullable();
            $table->decimal('performance_day' , 8, 3)->nullable();
            $table->decimal('performance_month' , 8, 3)->nullable();
            $table->decimal('performance_week' , 8, 3)->nullable();
            $table->decimal('performance_year' , 8, 3)->nullable();
            $table->decimal('performance_ytd' , 8, 3)->nullable();
            $table->string('technical_day')->nullable();
            $table->string('technical_hour')->nullable();
            $table->string('technical_month')->nullable();
            $table->string('technical_week')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
