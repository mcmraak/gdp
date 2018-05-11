<?php

Route::group(['middleware' => 'web'], function () {
    Route::post('/zen/gdp/api/parser/docs', 'Zen\Gdp\Controllers\Docs@go');
    Route::post('/zen/gdp/api/parser/doc', 'Zen\Gdp\Controllers\Docs@one');
});