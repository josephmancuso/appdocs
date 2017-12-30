<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', 'WelcomeController@show');

Route::domain('{repo}.'.env('SUBDOMAIN_URL'))->group(function () {
    // show the default version
    Route::get('/', 'MarkdownController@show');

    // show the default version
    Route::get('/docs/{slug}', 'MarkdownController@single');

    // show the default version
    Route::get('/v/{version}', 'MarkdownController@singleVersion');
    Route::get('/v/{version}/{slug}', 'MarkdownController@version');

    Route::get('/search/{version}', 'MarkdownController@searchVersion');
});

Route::get('/home', 'HomeController@show');
Route::get('/home/private', 'HomeController@showPrivate');
Route::get('/home/organization', 'HomeController@showOrganization');
Route::get('/home/repo/add/{id}', 'HomeController@repo');
Route::get('/home/repo/{id}', 'HomeController@detail')->name('repoDetails');
Route::post('/home/repo/{id}', 'HomeController@detailStore');

Route::post('/repo/download', 'HomeController@download');


Route::get('/login/github', 'auth\LoginController@githubToProvider');
Route::get('/integration/github', 'auth\LoginController@githubFromProvider');


Route::get('/download/{username}/{repo}', 'MarkdownController@download');
Route::get('/testing', 'MarkdownController@testFetch');

Route::post('/hook', 'UpdateController@hook');



Route::get('/', 'WelcomeController@show');

