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
        Schema::create('investor_coins', function (Blueprint $table) {
            $table->id();
            $table->double('available_balance')->default(0);
            $table->double('amount')->default(0);
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('coin_id');
            $table->unsignedBigInteger('investor_id');
            // key
            $table->foreign('coin_id')->references('id')->on('coin_models')->onDelete('cascade');
            $table->foreign('investor_id')->references('id')->on('investors')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_coins');
    }
};