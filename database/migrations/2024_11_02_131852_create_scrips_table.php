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
        Schema::create('scrips', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sector_id');
            $table->string('name');
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
        Schema::dropIfExists('scrips');
    }
};
