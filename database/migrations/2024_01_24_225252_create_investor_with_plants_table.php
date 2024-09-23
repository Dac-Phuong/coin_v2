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
        Schema::create('investor_with_plants', function (Blueprint $table) {
            $table->id();
            $table->string('name_coin');
            $table->string('amount')->default(0);
            $table->string('total_amount')->default(0);
            $table->integer('type_payment')->default(0);
            $table->integer('number_days')->default(0);
            $table->integer('status')->default(0);
            $table->double('profit')->default(0);
            $table->double('calculate_money')->default(0);
            $table->double('current_coin_price')->default(0);
            $table->double('network_fee')->default(0);
            $table->double('total_coin_price')->default(0);
            $table->integer('total_last_seconds')->default(0);
            $table->string('network_name')->nullable();
            $table->string('wallet_address')->nullable();
            $table->integer('wallet_id')->default(0);
            $table->integer('coin_id')->default(0);
            $table->bigInteger('plan_id')->default(0);
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
        Schema::dropIfExists('investor_with_plants');
    }
};