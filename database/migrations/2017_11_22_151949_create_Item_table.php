<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_name', 255);
            $table->string('item_code', 100)->nullable();
            $table->string('item_unit', 10)->nullable();
            $table->string('created_by', 255)->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('original_price', 16, 4)->default(0);
            $table->decimal('last_sales_price', 16, 4)->default(0);
            $table->decimal('last_purchase_price', 16, 4)->default(0);
            $table->timestamps();

            $table->index('item_name');
            $table->index('created_at');
            $table->unique('item_code');
            $table->engine = 'InnoDB';
        });

        Schema::create('Item_Purchase_History', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->default(0);
            $table->unsignedInteger('purchase_id')->default(0);
            $table->unsignedInteger('quantity')->default(1);
            $table->string('invoice_id', 255)->nullable();
            $table->decimal('unit_price', 16, 4)->default(0);
            $table->decimal('price', 16, 4)->default(0);
            $table->decimal('discount', 16, 4)->default(0);
            $table->decimal('total', 16, 4)->default(0);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('created_at');
            $table->index(['item_id', 'purchase_id']);
        });

        Schema::create('Item_Sales_History', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->default(0);
            $table->unsignedInteger('sales_id')->default(0);
            $table->unsignedInteger('quantity')->default(1);
            $table->string('invoice_id', 255)->nullable();
            $table->decimal('unit_price', 16, 4)->default(0);
            $table->decimal('price', 16, 4)->default(0);
            $table->decimal('discount', 16, 4)->default(0);
            $table->decimal('total', 16, 4)->default(0);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('created_at');
            $table->index(['item_id', 'sales_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Item_Sales_History');
        Schema::dropIfExists('Item_Purchase_History');
        Schema::dropIfExists('Item');
    }
}
