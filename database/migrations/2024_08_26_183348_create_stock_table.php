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
    Schema::create('stock', function (Blueprint $table) {
        $table->id();
        $table->string('sku')->nullable();
        $table->longText('ls_stock')->nullable();
        $table->longText('ls_cp')->nullable();
        $table->longText('alloy_stock')->nullable();
        $table->longText('alloy_cp')->nullable();
        $table->longText('mmt_stock')->nullable();
        $table->longText('mmt_cp')->nullable();
        $table->longText('ds_stock')->nullable();
        $table->longText('ds_cp')->nullable();
        $table->longText('dd_stock')->nullable();
        $table->longText('dd_cp')->nullable();
        $table->longText('rrp')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('stock');
}
};
