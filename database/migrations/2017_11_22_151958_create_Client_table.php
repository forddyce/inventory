<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Client', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('region_id')->default(0);
            $table->string('client_name', 255)->nullable();
            $table->string('client_phone', 100)->nullable();
            $table->string('created_by', 255)->nullable();
            $table->text('client_address')->nullable();
            $table->text('client_notes')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('created_at');
            $table->index('client_name');
        });

        Schema::create('Client_Regional', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('region_name', 255)->default('PARENT REGION');
            $table->string('created_by', 255)->nullable();
            $table->boolean('is_parent')->default(1);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('created_at');
            $table->index(['parent_id', 'is_parent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Client_Regional');
        Schema::dropIfExists('Client');
    }
}
