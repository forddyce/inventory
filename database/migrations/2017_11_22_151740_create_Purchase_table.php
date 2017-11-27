<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Purchase', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_id')->default(0);
            $table->string('invoice_id', 255)->default('INV-0');
            $table->string('created_by', 255)->nullable();
            $table->decimal('total_price', 16, 4)->default(0);
            $table->decimal('total_discount', 16, 4)->default(0);
            $table->decimal('total_final', 16, 4)->default(0);
            $table->text('purchase_info')->nullable();
            $table->boolean('is_complete')->default(1);
            $table->timestamps();

            $table->index(['created_at', 'is_complete']);
            $table->index('invoice_id');
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Purchase');
    }
}
