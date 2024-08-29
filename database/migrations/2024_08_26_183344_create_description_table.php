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
        Schema::create('description', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->longText('ls_description')->nullable();
            $table->longText('alloy_description')->nullable();
            $table->longText('alloy_short_description')->nullable();
            $table->longText('mmt_description')->nullable();
            $table->longText('ds_description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('description');
    }
};
