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
        Schema::create('ref', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->string('upc')->nullable();
            $table->string('ean')->nullable();
            $table->string('asin')->nullable();
            $table->string('barcode')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brand')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ref');
    }
};
