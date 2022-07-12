<?php

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
Route::get('/logout',function () {
    Auth::logout();
    return redirect('login');
});
Auth::routes();

Route::get('refreshCaptcha', 'Auth\LoginController@refreshCaptcha');
Route::post('setLayout', 'Auth\LoginController@setLayout');

Route::group(['prefix' => '/', 'namespace' => 'App', 'middleware' => 'auth'], function()
{
	# LANDING PAGE
	Route::get('/', function(){
		return redirect('home');
	});
	Route::get('home', 'HomeController@index');
	Route::get('home/profile', 'HomeController@profile');
	Route::post('home/change-profile', 'Pengaturan\UserController@change_profile');
	Route::post('home/change-password', 'Pengaturan\UserController@change_password');
	Route::get('home/lock', 'HomeController@lock');
	Route::post('home/unlock', 'HomeController@unlock');
	# END LANDING PAGE

	# PENGATURAN
	Route::group(['prefix' => 'pengaturan', 'namespace' => 'Pengaturan'], function()
	{
		Route::resource('menu', 'MenuController');
	    Route::resource('level', 'LevelController');
	    Route::resource('hak-akses', 'PermissionController');
	    Route::post('user/reset/{id}', 'UserController@reset');
	    Route::post('user/change-status/{id}', 'UserController@change_status');
	    Route::resource('user', 'UserController');
	    Route::resource('kontak', 'ContactController');
	    Route::resource('tentang-kami', 'AboutController');
	    Route::resource('sosial-media', 'SocialMediaController');
	    Route::resource('visi-misi', 'VisionController');
	    Route::resource('banner', 'BannerController');
	    Route::post('banner/deleteGambar', 'BannerController@deleteGambar');

	});

	Route::group(['prefix' => 'kamar', 'namespace' => 'Kamar'], function()
	{
		Route::resource('kamar-hotel', 'RoomController');
		Route::post('kamar-hotel/deleteGambar', 'RoomController@deleteGambar');
		Route::get('kamar-hotel/gambar/{id}', 'RoomController@gambar');
		Route::post('kamar-hotel/storewith', 'RoomController@storewith')->name('kamar-hotel.storewith');
		Route::post('kamar-hotel/destroyroom/{id}', 'RoomController@destroyroom')->name('kamar-hotel.destroyroom');
		Route::resource('fasilitas-kamar', 'RoomFacilityController');
	});
	# END PENGATURAN

	# BACKEND

	Route::resource('sekeliling', 'AroundController');
	Route::resource('galeri', 'GalleryController');
	Route::post('galeri/deleteGambar', 'GalleryController@deleteGambar');
	Route::resource('event', 'EventController');
	Route::post('event/deleteGambar', 'EventController@deleteGambar');
	Route::post('event/destroyevent/{id}', 'EventController@destroyevent')->name('event.destroyevent');
	Route::get('event/gambar/{id}', 'EventController@gambar');
	Route::post('event/storewith', 'EventController@storewith')->name('event.storewith');
	Route::resource('promosi', 'PromotionController');
	Route::post('promosi/deleteGambar', 'PromotionController@deleteGambar');
	Route::post('promosi/destroypromotion/{id}', 'PromotionController@destroypromotion')->name('promosi.destroypromotion');
	Route::get('promosi/gambar/{id}', 'PromotionController@gambar');
	Route::post('promosi/storewith', 'PromotionController@storewith')->name('promosi.storewith');
	Route::resource('fasilitas', 'FacilityController');
	


	# END BACKEND
});