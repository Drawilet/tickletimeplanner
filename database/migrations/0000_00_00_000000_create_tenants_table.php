<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->string('phone');
            $table->string('email');
            $table->boolean('suspended')->default(false);

            $table->string('background_image')->nullable();
            $table->string('profile_image')->nullable();

            $table->foreignId('plan_id')->constrained();
            $table->foreignId('next_plan_id')->nullable()->constrained('plans');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
};
