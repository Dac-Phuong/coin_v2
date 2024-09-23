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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->double('amount')->default(0);
            $table->double('total_amount')->default(0);
            $table->double('old_coin_price')->default(0);
            $table->integer('status')->default(0);
            $table->string('wallet_address')->nullable();
            $table->string('wallet_name')->nullable();
            $table->string('coin_name')->nullable();
            $table->integer('coin_id')->default(0);
            $table->unsignedBigInteger('investor_id');
            $table->timestamps();
            // key
            $table->foreign('investor_id')->references('id')->on('investors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};