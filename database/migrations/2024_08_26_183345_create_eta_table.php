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
    Schema::create('eta', function (Blueprint $table) {
        $table->id();
        $table->string('sku')->nullable();
        $table->longText('vic')->nullable();
        $table->longText('nsw')->nullable();
        $table->longText('adl')->nullable();
        $table->longText('qld')->nullable();
        $table->longText('wa')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('eta');
}
};
