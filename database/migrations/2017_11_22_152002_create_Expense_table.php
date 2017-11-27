<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Expense', function (Blueprint $table) {
            $table->increments('id');
            $table->string('expense_name', 255)->default('EXPENSE NAME');
            $table->string('created_by', 255)->nullable();
            $table->text('expense_notes')->nullable();
            $table->decimal('amount', 16, 4)->default(0);
            $table->timestamps();

            $table->index('created_at');
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
        Schema::dropIfExists('Expense');
    }
}
