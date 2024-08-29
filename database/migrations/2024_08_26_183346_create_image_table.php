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
        Schema::create('image', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->longText('ls_image')->nullable();
            $table->longText('alloy_image')->nullable();
            $table->longText('mmt_image')->nullable();
            $table->longText('ds_image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('image');
    }
};
