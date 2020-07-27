<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendaHasItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda_has_item', function (Blueprint $table) {
            $table->increments('id');

            $table->addColumn("integer", 'venda_id', [
                "length" => 10,
                "unsigned" => true
            ]);

            $table->addColumn("integer", 'item_id', [
                "length" => 10,
                "unsigned" => true
            ]);

            $table->integer('quantidade');
            $table->double('preco');

            $table->foreign('venda_id')->references('id')->on('venda');
            $table->foreign('item_id')->references('id')->on('item');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda_has_item');
    }
}
