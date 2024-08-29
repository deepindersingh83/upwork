<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->longText('c1')->nullable();
            $table->longText('c2')->nullable();
            $table->longText('c3')->nullable();
            $table->longText('c4')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category');
    }

};
