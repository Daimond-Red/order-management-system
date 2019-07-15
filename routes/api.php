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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([ 'middleware' => 'api', 'prefix' => 'users', 'namespace' => 'Api' ], function() {

	Route::post('register', 'UserController@register');

	Route::post('verifyOtp', 'UserController@verifyOtp');

	Route::post('resendOtp', 'UserController@resendOtp');

	Route::post('login', 'UserController@login');

	Route::post('resentOtp', 'UserController@resentOtp');

	Route::post('forgetPassword', 'UserController@forgetPassword');

});
Route::group([ 'middleware' => 'user.auth' ], function() {

	Route::group([ 'middleware' => 'auth:api', 'namespace' => 'Api' ], function() {
		/*
			-- logout
			-- get dashboard data // for cutomer
			-- document upload // Done
			-- update vendor profile
			-- get vehicle types // Done 
			-- get cargo types // Done
			-- get rating and reviews
			-- create booking // Done
			-- get bookings // Done
			-- get booking details 
			-- create vendor bid // Done
			-- get bid list against booking // Done
			-- Bid confirmation // Done
			-- reschedule booking request
			-- confirmation on reschedule booking
			-- assign vehicle and driver // Done
			-- complete booking 
			-- give rating against booking // Done
			-- get biding history
			-- create driver // Done
			-- get drivers // Done
			-- get permit type
			-- create vehicle // Done
			-- get vehicles // Done
			-- driver login and verify otp
			-- get completed booking // 
			-- get cancel booking // 
			-- get expired  booking // 

			out for delivery, request for complete, mark as completed
			
		*/

		Route::post('userDetails', 'UserController@userDetails');

        Route::post('postAddress', 'UserController@postAddress');
        
        Route::post('getPostedAddresses', 'UserController@getPostedAddresses');

		Route::post('users/profileUpdate', 'UserController@profileUpdate');

		Route::post('logout', 'UserController@logout');

		Route::post('vehicleTypes/list', 'VehicleTypeController@index');

		Route::post('cargoTypes/list', 'CargoTypeController@index');

		

		Route::post('bookings/store', 'BookingController@store');

		Route::post('bookings/allocateBookingToVendor', 'BookingController@allocateBookingToVendor');

		// This booking list for vendor where status pending
		Route::post('bookings/list', 'BookingController@index');

		Route::post('vendors/bookings/list', 'BookingController@vendorBookings');

		Route::post('customers/bookings/list', 'BookingController@customersBooking');

		Route::post('bookings/bid/store', 'BookingController@bidStore');

		Route::post('bookings/bid/list', 'BookingController@bidIndex');

		// Customer confirm the booking with vendor
		Route::post('bookings/bid/confirm', 'BookingController@confirmBid');

		Route::post('bookings/assign/vehicle/driver', 'BookingController@assignVehicleDriver');

		Route::post('bookings/outForDelivery', 'BookingController@outForDelivery');

		Route::post('bookings/requestForCompleteBooking', 'BookingController@requestForCompleteBooking');

		Route::post('bookings/markAsCompleted', 'BookingController@markAsCompleted');

		// Route::post('bookings/completed', 'BookingController@completed');

		Route::post('bookings/ratingReview', 'BookingController@ratingReview');

		Route::post('bookings/cancelBooking', 'BookingController@cancelBooking');

		Route::post('bookings/statusUpdate', 'BookingController@statusUpdate');

		Route::post('drivers/store', 'DriverController@store');

		Route::post('vendors/drivers/list', 'DriverController@driverList');

		Route::post('vehicles/store', 'VehicleController@store');

		Route::post('vehicles/update', 'VehicleController@update');

		Route::post('vendors/vehicles/list', 'VehicleController@vehicleList');

		Route::post('vehicles/availableVehicleList', 'VehicleController@availableVehicleList');
		
		Route::post('vehicles/availablePastVehicleList', 'VehicleController@availablePastVehicleList');

		Route::post('vehicles/vehiclesAgainstBooking', 'VehicleController@vehiclesAgainstBooking');

		Route::post('customers/bookings/history', 'BookingController@customerHistory');

		Route::post('vendors/bookings/history', 'BookingController@vendorHistory');

		Route::post('contacts/store', 'ContactUsController@store');

		Route::post('customers/dashboard', 'CustomerController@dashboard');

		Route::post('drivers/currentPosition', 'DriverController@currentPosition');

		Route::post('bookings/findLoad', 'BookingController@findLoad');

		Route::post('contactUs/customer/reply', 'ContactUsController@reply');

		Route::post('customerChat', 'ContactUsController@customerChat');

		Route::post('customers/queryList', 'ContactUsController@queryList');

		Route::post('drivers/bookings', 'DriverController@driverBookings');

		Route::post('getAppNotification', 'UserController@getAppNotification');

		Route::post('chats', 'ChatController@chats');

		Route::post('chats/store', 'ChatController@store');

		Route::post('chats/logs/store', 'ChatController@logStore');

		Route::post('vendors/chat/list', 'ChatController@chatList');
	});
});

Route::group([ 'middleware' => 'auth:api', 'namespace' => 'Api' ], function() {

	Route::post('documents/store', 'DocumentController@store');
});
Route::group([ 'namespace' => 'Api' ], function() {

	Route::post('cities/list', 'CityController@index');

	Route::post('states/list', 'CityController@stateList');
});