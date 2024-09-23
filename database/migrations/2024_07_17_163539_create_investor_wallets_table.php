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
        Schema::create('investor_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_address')->nullable();
            $table->integer('status')->default(0);
            $table->integer('investor_id')->nullable();
            $table->unsignedBigInteger('network_id');
            // key
            $table->foreign('network_id')->references('id')->on('networks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_wallets');
    }
};