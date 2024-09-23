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
        Schema::create('referal_details', function (Blueprint $table) {
            $table->id();
            $table->double('amount_received')->default(0);
            $table->integer('number_referals')->default(0);
            $table->integer('status')->default(0);
            $table->string('parent_code')->nullable();
            $table->bigInteger('investor_id')->default(0);
            $table->bigInteger('coin_id')->default(0);
            $table->unsignedBigInteger('referal_id');
            $table->timestamps();
            // key
            $table->foreign('referal_id')->references('id')->on('referals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referal_details');
    }
};