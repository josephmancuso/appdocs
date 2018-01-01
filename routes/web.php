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
    Route::get('/', 'MarkdownController@show')->where('repo', '^((?!www).)*$');

    // show the default version
    Route::get('/docs/{slug}', 'MarkdownController@single')->where('repo', '^((?!www).)*$');;

    // show the default version
    Route::get('/v/{version}', 'MarkdownController@singleVersion')->where('repo', '^((?!www).)*$');;
    Route::get('/v/{version}/{slug}', 'MarkdownController@version')->where('repo', '^((?!www).)*$');;

    Route::get('/search/{version}', 'MarkdownController@searchVersion')->where('repo', '^((?!www).)*$');;
});

Route::get('/home', 'HomeController@show');
Route::get('/home/private', 'HomeController@showPrivate')->middleware('anyPlan');
Route::get('/home/organization', 'HomeController@showOrganization')->middleware('organizationPlan');
Route::get('/home/repo/add/{id}', 'HomeController@repo');
Route::get('/home/repo/{id}', 'HomeController@detail')->name('repoDetails');
Route::post('/home/repo/{id}', 'HomeController@detailStore');

Route::post('/repo/download', 'HomeController@download');


Route::get('/login/github', 'Auth\LoginController@githubToProvider');
Route::get('/integration/github', 'Auth\LoginController@githubFromProvider');


Route::get('/download/{username}/{repo}', 'MarkdownController@download');

Route::post('/hook', 'UpdateController@hook');



Route::get('/', 'WelcomeController@show');

