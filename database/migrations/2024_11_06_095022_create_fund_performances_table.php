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
        Schema::create('fund_performances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fund_id');
            $table->date('validity_date');
            $table->float('nav');
            $table->float('ytd');
            $table->float('mtd');
            $table->float('day_1');
            $table->float('day_15');
            $table->float('day_30');
            $table->float('year_2');
            $table->float('year_3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_performances');
    }
};
