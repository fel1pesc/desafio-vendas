<?php

Route::group(['prefix' => 'item'], function () {

    Route::get('/', 'ItemController@index')->name('item.index');

    Route::get('/create', 'ItemController@create')->name('item.create');

    Route::post('/store', 'ItemController@store')->name('item.store');

    Route::get('/edit/{item}', 'ItemController@edit')->name('item.edit');

    Route::post('/destroy', 'ItemController@destroy')->name('item.destroy');

});