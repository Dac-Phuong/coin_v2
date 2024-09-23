<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('plan_models')) {
            Schema::create('plan_models', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('title');
                $table->string('number_date')->default(0);
                $table->double('discount')->default(0);
                $table->timestamp('from_date')->nullable();
                $table->timestamp('to_date')->nullable();
                $table->timestamp('end_date')->nullable();
                $table->integer('package_type')->default(0);
                $table->integer('type_date')->default(0);
                $table->bigInteger('coin_id')->default(0);
                $table->double('min_deposit')->default(0);
                $table->double('termination_fee')->default(0);
                $table->double('max_deposit')->default(0);
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('plan_models');
    }

};