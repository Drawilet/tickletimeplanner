<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->id();

            $table->string("name");
            $table->text("description");

            $table->string("address");
            $table->string("city");
            $table->string("state");
            $table->string("country");

            $table->json("schedule");

            $table->string("color");
            $table->text('notes')->nullable();


            $table->foreignId("tenant_id")->constrained("tenants");

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
        Schema::dropIfExists('spaces');
    }
};
