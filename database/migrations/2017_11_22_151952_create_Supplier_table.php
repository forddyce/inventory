<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_name', 255)->nullable();
            $table->string('supplier_phone', 100)->nullable();
            $table->string('created_by', 255)->nullable();
            $table->text('supplier_address')->nullable();
            $table->text('supplier_notes')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('created_at');
            $table->index('supplier_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Supplier');
    }
}
