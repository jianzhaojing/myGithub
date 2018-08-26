<?php
Route::get('articles','ArticleController@article')->name('api.v1.articles');
Route::post('articles','ArticleController@store')->name('api.v1.articles');
//Route::put('articles/{id?}','ArticleController@update')->name('api.v1.articles');
Route::put('articles/{article?}','ArticleController@update')->name('api.v1.articles');
Route::delete('articles/{article?}','ArticleController@destroy')->name('api.v1.articles');
