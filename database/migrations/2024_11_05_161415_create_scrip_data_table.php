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
        Schema::create('scrip_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scrip_id');
            $table->date('scrip_date');
            $table->float('ldcp');
            $table->float('open');
            $table->float('high');
            $table->float('low');
            $table->float('current');
            $table->float('change');
            $table->double('volume');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrip_data');
    }
};
