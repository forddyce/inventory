<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->default(0);
            $table->string('invoice_id', 255)->default('INV-0');
            $table->string('created_by', 255)->nullable();
            $table->decimal('total_gross', 16, 4)->default(0);
            $table->decimal('total_discount', 16, 4)->default(0);
            $table->decimal('total_net', 16, 4)->default(0);
            $table->text('sales_info')->nullable();
            $table->boolean('is_complete')->default(1);
            $table->timestamps();

            $table->index(['created_at', 'is_complete']);
            $table->index('invoice_id');
            $table->engine = 'InnoDB';
        });

        Schema::create('Sales_ItemPurchase_History', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_id');
            $table->unsignedInteger('history_id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('quantity_used');
            $table->timestamps();

            $table->index(['sales_id', 'history_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Sales_ItemPurchase_History');
        Schema::dropIfExists('Sales');
    }
}
