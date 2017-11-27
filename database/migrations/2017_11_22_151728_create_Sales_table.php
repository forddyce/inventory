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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Sales');
    }
}
