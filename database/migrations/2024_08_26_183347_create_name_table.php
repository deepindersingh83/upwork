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
    Schema::create('name', function (Blueprint $table) {
        $table->id();
        $table->string('sku')->nullable();
        $table->longText('ls_name')->nullable();
        $table->longText('alloy_name')->nullable();
        $table->longText('mmt_name')->nullable();
        $table->longText('ds_name')->nullable();
        $table->longText('dd_name')->nullable();
        $table->longText('synnex_name')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('name');
}
};
