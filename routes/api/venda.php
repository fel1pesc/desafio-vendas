<?php

Route::group(['prefix' => 'venda'], function () {

    Route::get('/obter-vendas', 'Api\VendaController@obterVendas');

    Route::get('/obter-venda/{vendaId}', 'Api\VendaController@obterVendaPorId');

});