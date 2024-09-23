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
        Schema::create('coin_models', function (Blueprint $table) {
            $table->id();
            $table->string('coin_name')->nullable();
            $table->double('coin_price')->default(0);
            $table->double('coin_fee')->default(0);
            $table->double('min_withdraw')->default(0);
            $table->double('coin_decimal')->default(4);
            $table->string('coin_image')->nullable();
            $table->longText('network_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('rate_coin')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_models');
    }
};