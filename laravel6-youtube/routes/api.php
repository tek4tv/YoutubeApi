<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/playlists',"VideoController@GetAllPlayList");
Route::post('/CreatePlaylits',"VideoController@CreatePlaylist");

Route::post('/CreateVideo',"VideoController@CreateVideo");



Route::post('/PlaylistById',"VideoController@GetPlaylistById");

Route::post('/InsertToPlaylist',"VideoController@InsertToPlaylist");
Route::post('/Delete',"VideoController@DeleteVideo");
Route::get('/Token',"VideoController@GetToken");
Route::post('/SetEnv',"VideoController@SetEnv");

Route::post('/refresh',"VideoController@RefreshToken");








