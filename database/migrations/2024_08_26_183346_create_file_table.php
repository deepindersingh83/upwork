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
    Schema::create('file', function (Blueprint $table) {
        $table->id();
        $table->string('sku')->nullable();
        $table->longText('alloy_file')->nullable();
        $table->longText('ds_file')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('file');
}
};
