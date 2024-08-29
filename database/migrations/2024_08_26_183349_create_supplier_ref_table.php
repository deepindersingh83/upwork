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
        Schema::create('supplier_ref', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->string('ls_code')->nullable();
            $table->string('alloy_code')->nullable();
            $table->string('mmt_code')->nullable();
            $table->string('ds_code')->nullable();
            $table->string('dd_code')->nullable();
            $table->string('synnex_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplier_ref');
    }
};
