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
        Schema::create('plan_number_days', function (Blueprint $table) {
            $table->id();
            $table->integer('number_days')->default(0);
            $table->double('profit')->default(0);
            $table->bigInteger('coin_id')->default(0);
            $table->unsignedBigInteger('plan_id');
            // key
            $table->foreign('plan_id')->references('id')->on('plan_models')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_number_days');
    }
};