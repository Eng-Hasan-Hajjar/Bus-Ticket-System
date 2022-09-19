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

Route::get('/', function () { 
	return view('welcome-content'); 
});
// Registration Routes
Route::get('registration', 'BusAuthController@showRegistrationForm');
Route::post('register', 'BusAuthController@register')->name('register');

// Login Routes
Route::get('login-form', 'BusAuthController@showLoginForm')->name('login-form');
Route::post('login', 'BusAuthController@login')->name('login');
Route::get('logout', 'BusAuthController@logout');

// Verify account
Route::get('/token/{token}', 'BusAuthController@verify')->name('user.verification');

// Customer Routes
Route::get('customer-welcome', 'CustomerController@index');
Route::get('customer-profile', 'CustomerController@profile');

Route::get('edit-profile-form', 'CustomerController@showEditProfileForm');
Route::post('update-profile-info', 'CustomerController@updateProfileInfo')->name('update-profile-info');

// Booking Routes
Route::get('booking-form', 'CustomerController@showBookingForm');
Route::post('booking-now', 'CustomerController@bookingNow')->name('booking-now');
Route::get('show-bus-list', 'CustomerController@showBusList')->name('show-bus-list');
Route::get('show-bus-seat-detail/{id}', 'CustomerController@showBusSeatDetail')->name('booking-form');

// Admin Route
Route::get('admin/login', 'BusAuthController@showAdminLoginForm');
Route::get('admin/dashboard', 'AdminController@index');
Route::get('admin/bus-list', 'AdminController@busList');
Route::post('admin-login', 'BusAuthController@adminLogin')->name('admin-login');
Route::get('admin-logout', 'BusAuthController@adminLogout');
Route::get('admin/add-bus', 'AdminController@showAddBusForm');
Route::post('admin-add-bus', 'AdminController@addBus')->name('admin-add-bus');
Route::delete('admin/delete-bus/{id}', 'AdminController@deleteBus');

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');