<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coin_plans', function (Blueprint $table) {
            $table->id();
            $table->double('profit')->default(0);
            $table->double('number_days')->default(0);
            $table->unsignedBigInteger('coin_id');
            $table->unsignedBigInteger('plan_id');
            // key
            $table->foreign('coin_id')->references('id')->on('coin_models')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plan_models')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_plans');
    }
};