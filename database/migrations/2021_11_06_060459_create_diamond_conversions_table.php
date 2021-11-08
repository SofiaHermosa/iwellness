<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiamondConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversion_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('mechanics')->nullable();
            $table->json('variants')->nullable();
            $table->json('images')->nullable();
            $table->string('price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversion_items');
    }
}
