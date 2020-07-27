<?php

Route::group(['prefix' => 'venda'], function () {

    Route::get('/', 'VendaController@index')->name('venda.index');

    Route::get('/create', 'VendaController@create')->name('venda.create');

    Route::post('/store', 'VendaController@store')->name('venda.store');

    Route::get('/edit/{venda}', 'VendaController@edit')->name('venda.edit');

    Route::post('/destroy', 'VendaController@destroy')->name('venda.destroy');

    Route::get('/obter-itens/{vendaId}', 'VendaController@obterItensParaFormPorVendaId');

});