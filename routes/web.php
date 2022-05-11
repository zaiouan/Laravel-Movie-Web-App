<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login/facebook','LoginController@facebook') ->middleware('guest');
Route::get('/login/facebook/redirect','LoginController@facebookRedirect') ->middleware('guest');
Route::get('/login/google','LoginController@google') ->middleware('guest');
Route::get('/login/google/redirect','LoginController@googleRedirect') ->middleware('guest');
Route::group(['middleware' => ['auth']], function (){
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::get('/movies/{id}', 'MovieController@show')->name('movies.show');
    Route::get('/series/{id}', 'SerieController@show')->name('series.show');
    Route::get('/movies', 'MovieController@index')->name('movies');
    Route::get('/series', 'SerieController@index')->name('series');
    Route::post('/dashboard', 'MovieController@store')->name('movie.store');
    Route::post('/', 'SerieController@store')->name('serie.store');
    Route::get('/profile','DashboardController@profil')->name('dashboard.profil');
    Route::get('/movie/{id}', 'DashboardController@show1')->name('show');
    Route::get('/serie/{id}', 'DashboardController@show2')->name('show2');
    Route::get('/actor/{id}', 'ActorController@show')->name('actor.show');
});

Route::group(['middleware' => ['auth','role:admin']], function (){


    Route::get('/users', 'DashboardController@indexUser')->name('user.index');
    Route::post('/movie', 'CrewController@store')->name('crew.store');
    Route::post('/actor2', 'ActorController@storeapi')->name('actorapi.store');
    Route::post('/movie1', 'ActorController@store')->name('actor.store');
    Route::post('/movie2', 'ImageController@store')->name('image.store');
    Route::post('/serie', 'CrewController@store2')->name('S_crew.store');
    Route::post('/serie1', 'ActorController@store2')->name('S_actor.store');
    Route::post('/serie2', 'ImageController@store2')->name('S_image.store');
    Route::post('/movies', 'MovieController@storeapi')->name('moviesapi.store');
    Route::delete('/moviedelete/{id}', 'MovieController@destroy')->name('movie.delete');
    Route::delete('/seriedelete/{id}', 'SerieController@destroy')->name('serie.delete');
    Route::delete('/actordelete/{id}', 'ActorController@destroy')->name('actor.delete');
    Route::delete('/userdelete/{id}', 'DashboardController@destroy')->name('user.delete');
    Route::post('/series', 'SerieController@storeapi')->name('seriesapi.store');
    Route::get('/actors_api/page/{page?}', 'DashboardController@indexactor');
    Route::get('/actors_api/{id}', 'ActorController@showapi')->name('actorsapi.show');
    Route::get('/series_api/{id}', 'SerieController@showapi')->name('seriesapi.show');
    Route::get('/actors', 'ActorController@index')->name('actors.index');

});

Route::get('/actor', 'DashboardController@indexactor')->name('actor');
Route::get('/movie', 'DashboardController@indexmovie')->name('movie');
Route::get('/serie', 'DashboardController@indexserie')->name('serie');

require __DIR__.'/auth.php';
