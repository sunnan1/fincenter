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
        Schema::create('fund_scrips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fund_id')->index();
            $table->unsignedBigInteger('scrip_id')->index();
            $table->float('equity_per');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_scrips');
    }
};
