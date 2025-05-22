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
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('admin.dashboard');


Route::group(['middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

	Route::get('vehicleTypes', ['as' => 'admin.vehicleTypes.index', 'uses' => 'VehicleTypeController@index']);
    Route::get('vehicleTypes/create', ['as' => 'admin.vehicleTypes.create', 'uses' => 'VehicleTypeController@create']);
    Route::post('vehicleTypes', ['as' => 'admin.vehicleTypes.store', 'uses' => 'VehicleTypeController@store']);
    Route::get('vehicleTypes/{id}/edit', ['as' => 'admin.vehicleTypes.edit', 'uses' => 'VehicleTypeController@edit']);
    Route::put('vehicleTypes/{id}', ['as' => 'admin.vehicleTypes.update', 'uses' => 'VehicleTypeController@update']);
    Route::get('vehicleTypes/{id}/destroy', ['as' => 'admin.vehicleTypes.delete', 'uses' => 'VehicleTypeController@destroy']);

    Route::get('cargoTypes', ['as' => 'admin.cargoTypes.index', 'uses' => 'CargoTypeController@index']);
    Route::get('cargoTypes/create', ['as' => 'admin.cargoTypes.create', 'uses' => 'CargoTypeController@create']);
    Route::post('cargoTypes', ['as' => 'admin.cargoTypes.store', 'uses' => 'CargoTypeController@store']);
    Route::get('cargoTypes/{id}/edit', ['as' => 'admin.cargoTypes.edit', 'uses' => 'CargoTypeController@edit']);
    Route::put('cargoTypes/{id}', ['as' => 'admin.cargoTypes.update', 'uses' => 'CargoTypeController@update']);
    Route::get('cargoTypes/{id}/destroy', ['as' => 'admin.cargoTypes.delete', 'uses' => 'CargoTypeController@destroy']);

    // Route::get('users', ['as' => 'admin.users.index', 'uses' => 'UserController@index']);
    // Route::get('users/create', ['as' => 'admin.users.create', 'uses' => 'UserController@create']);
    // Route::post('users', ['as' => 'admin.users.store', 'uses' => 'UserController@store']);
    // Route::get('users/{id}/edit', ['as' => 'admin.users.edit', 'uses' => 'UserController@edit']);
    // Route::put('users/{id}', ['as' => 'admin.users.update', 'uses' => 'UserController@update']);
    // Route::get('users/{id}/destroy', ['as' => 'admin.users.delete', 'uses' => 'UserController@destroy']);
    


    Route::get('tests', ['as' => 'admin.tests.index', 'uses' => 'TestController@index']);
    Route::get('tests/create', ['as' => 'admin.tests.create', 'uses' => 'TestController@create']);
    Route::post('tests', ['as' => 'admin.tests.store', 'uses' => 'TestController@store']);
    Route::get('tests/{id}/edit', ['as' => 'admin.tests.edit', 'uses' => 'TestController@edit']);
    Route::put('tests/{id}', ['as' => 'admin.tests.update', 'uses' => 'TestController@update']);
    Route::get('tests/{id}/destroy', ['as' => 'admin.tests.delete', 'uses' => 'TestController@destroy']);
});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('customers', [ 'as' => 'admin.customers.index', 'uses' => 'CustomerController@index' ]);
    Route::get('customers/create', [ 'as' => 'admin.customers.create', 'uses' => 'CustomerController@create' ]);
    Route::post('customers', [ 'as' => 'admin.customers.store', 'uses' => 'CustomerController@store' ]);
    Route::get('customers/{id}', [ 'as' => 'admin.customers.show', 'uses' => 'CustomerController@show' ]);
    Route::get('customers/{id}/edit', [ 'as' => 'admin.customers.edit', 'uses' => 'CustomerController@edit' ]);
    Route::put('customers/{id}', [ 'as' => 'admin.customers.update', 'uses' => 'CustomerController@update' ]);
    Route::get('customers/{id}/destroy', [ 'as' => 'admin.customers.delete', 'uses' => 'CustomerController@destroy' ]);
    Route::get('search/customers', [ 'as' => 'admin.customers.search', 'uses' => 'CustomerController@search' ]);
    Route::get('customers/{userId}/documents', [ 'as' => 'admin.customers.documents', 'uses' => 'CustomerController@documents' ]);


    Route::get('vendors', [ 'as' => 'admin.vendors.index', 'uses' => 'VendorController@index' ]);
    Route::get('vendors/create', [ 'as' => 'admin.vendors.create', 'uses' => 'VendorController@create' ]);
    Route::post('vendors', [ 'as' => 'admin.vendors.store', 'uses' => 'VendorController@store' ]);
    Route::get('vendors/{id}', [ 'as' => 'admin.vendors.show', 'uses' => 'VendorController@show' ]);
    Route::get('vendors/{id}/edit', [ 'as' => 'admin.vendors.edit', 'uses' => 'VendorController@edit' ]);
    Route::put('vendors/{id}', [ 'as' => 'admin.vendors.update', 'uses' => 'VendorController@update' ]);
    Route::get('vendors/{id}/destroy', [ 'as' => 'admin.vendors.delete', 'uses' => 'VendorController@destroy' ]);
    Route::get('search/vendors', [ 'as' => 'admin.vendors.search', 'uses' => 'VendorController@search' ]);

    Route::get('drivers', ['uses' => 'DriverController@index', 'as' => 'admin.drivers.driverList']);
    Route::get('vendors/{vendor_id}/drivers', ['uses' => 'DriverController@index_driver', 'as' => 'admin.drivers.index']);
    Route::get('vendors/{vendor_id}/add_driver', ['uses' => 'DriverController@add_driver', 'as' => 'admin.drivers.create']);
    Route::post('vendors/{vendor_id}/add_driver', ['uses' => 'DriverController@store_driver', 'as' => 'admin.drivers.store']);
    Route::get('vendors/{vendor_id}/drivers/{driver_id}', ['uses' => 'DriverController@show_driver', 'as' => 'admin.drivers.show']);
    Route::get('vendors/{vendor_id}/edit_driver/{driver_id}', ['uses' => 'DriverController@edit_driver', 'as' => 'admin.drivers.edit']);
    Route::put('vendors/{vendor_id}/edit_driver/{driver_id}', ['uses' => 'DriverController@update_driver', 'as' => 'admin.drivers.update']);
    Route::get('vendors/{vendor_id}/delete_driver/{driver_id}', ['uses' => 'DriverController@delete_driver', 'as' => 'admin.drivers.delete']);

    Route::get('vendors/{vendor_id}/vehicles', ['uses' => 'VehicleController@index_vehicle', 'as' => 'admin.vehicles.index']);
    Route::get('vendors/{vendor_id}/add_vehicle', ['uses' => 'VehicleController@add_vehicle', 'as' => 'admin.vehicles.create']);
    Route::post('vendors/{vendor_id}/add_vehicle', ['uses' => 'VehicleController@store_vehicle', 'as' => 'admin.vehicles.store']);
    Route::get('vendors/{vendor_id}/vehicles/{vehicle_id}', ['uses' => 'VehicleController@show_vehicle', 'as' => 'admin.vehicles.show']);
    Route::get('vendors/{vendor_id}/edit_vehicle/{vehicle_id}', ['uses' => 'VehicleController@edit_vehicle', 'as' => 'admin.vehicles.edit']);
    Route::put('vendors/{vendor_id}/edit_vehicle/{vehicle_id}', ['uses' => 'VehicleController@update_vehicle', 'as' => 'admin.vehicles.update']);
    Route::get('vendors/{vendor_id}/delete_vehicle/{vehicle_id}', ['uses' => 'VehicleController@delete_vehicle', 'as' => 'admin.vehicles.delete']);

    Route::get('promotion/images', [ 'as' => 'admin.promotionImages.index', 'uses' => 'PromotionImageController@index' ]);
    Route::get('promotion/images/create', [ 'as' => 'admin.promotionImages.create', 'uses' => 'PromotionImageController@create' ]);
    Route::post('promotion/images', [ 'as' => 'admin.promotionImages.store', 'uses' => 'PromotionImageController@store' ]);
    Route::get('promotion/images/{id}', [ 'as' => 'admin.promotionImages.show', 'uses' => 'PromotionImageController@show' ]);
    Route::get('promotion/images/{id}/edit', [ 'as' => 'admin.promotionImages.edit', 'uses' => 'PromotionImageController@edit' ]);
    Route::put('promotion/images/{id}', [ 'as' => 'admin.promotionImages.update', 'uses' => 'PromotionImageController@update' ]);
    Route::get('promotion/images/{id}/destroy', [ 'as' => 'admin.promotionImages.delete', 'uses' => 'PromotionImageController@destroy' ]);


    Route::get('pages', [ 'as' => 'admin.pages.index', 'uses' => 'PageController@index' ]);
    Route::get('pages/create', [ 'as' => 'admin.pages.create', 'uses' => 'PageController@create' ]);
    Route::post('pages', [ 'as' => 'admin.pages.store', 'uses' => 'PageController@store' ]);
    Route::get('pages/{id}', [ 'as' => 'admin.pages.show', 'uses' => 'PageController@show' ]);
    Route::get('pages/{id}/edit', [ 'as' => 'admin.pages.edit', 'uses' => 'PageController@edit' ]);
    Route::put('pages/{id}', [ 'as' => 'admin.pages.update', 'uses' => 'PageController@update' ]);
    Route::get('pages/{id}/destroy', [ 'as' => 'admin.pages.delete', 'uses' => 'PageController@destroy' ]);

    Route::get('documents/{userId}', [ 'as' => 'admin.documents.index', 'uses' => 'DocumentController@documents' ]);
    Route::get('documents/{userId}/create', [ 'as' => 'admin.documents.create', 'uses' => 'DocumentController@create' ]);
    Route::post('documents', [ 'as' => 'admin.documents.store', 'uses' => 'DocumentController@store' ]);
    Route::get('documents/{id}', [ 'as' => 'admin.documents.show', 'uses' => 'DocumentController@show' ]);
    Route::get('documents/{id}/edit', [ 'as' => 'admin.documents.edit', 'uses' => 'DocumentController@edit' ]);
    Route::put('documents/{id}', [ 'as' => 'admin.documents.update', 'uses' => 'DocumentController@update' ]);
    Route::get('documents/{id}/destroy', [ 'as' => 'admin.documents.delete', 'uses' => 'DocumentController@destroy' ]);

    
    Route::get('bookings', [ 'as' => 'admin.bookings.pendingBooking', 'uses' => 'BookingController@pendingBooking' ]);
    Route::get('completedBooking', [ 'as' => 'admin.bookings.completedBooking', 'uses' => 'BookingController@completedBooking' ]);
    Route::get('confirmedBooking', [ 'as' => 'admin.bookings.confirmedBooking', 'uses' => 'BookingController@confirmedBooking' ]);
    Route::get('expiredBooking', [ 'as' => 'admin.bookings.expiredBooking', 'uses' => 'BookingController@expiredBooking' ]);
    Route::get('cancelBooking', [ 'as' => 'admin.bookings.cancelBooking', 'uses' => 'BookingController@cancelBooking' ]);
    Route::get('liveBooking', [ 'as' => 'admin.bookings.liveBooking', 'uses' => 'BookingController@liveBooking' ]);
    Route::get('bookingDetail/{id}', [ 'as' => 'admin.bookingDetail', 'uses' => 'BookingController@bookingDetail' ]);
    Route::get('bookings/{bookingId}/map', ['as' => 'admin.bookings.map', 'uses' => 'BookingController@map']);


    Route::get('appNotifications', [ 'as' => 'admin.appNotifications.index', 'uses' => 'AppNotificationController@index' ]);
    Route::get('appNotifications/create', [ 'as' => 'admin.appNotifications.create', 'uses' => 'AppNotificationController@create' ]);
    Route::post('appNotifications', [ 'as' => 'admin.appNotifications.store', 'uses' => 'AppNotificationController@store' ]);
    Route::get('appNotifications/{id}', [ 'as' => 'admin.appNotifications.show', 'uses' => 'AppNotificationController@show' ]);
    Route::get('appNotifications/{id}/edit', [ 'as' => 'admin.appNotifications.edit', 'uses' => 'AppNotificationController@edit' ]);
    Route::put('appNotifications/{id}', [ 'as' => 'admin.appNotifications.update', 'uses' => 'AppNotificationController@update' ]);
    Route::get('appNotifications/{id}/destroy', [ 'as' => 'admin.appNotifications.delete', 'uses' => 'AppNotificationController@destroy' ]);


    Route::get('push/configurations', ['uses' => 'AppConfigController@configurations', 'as' => 'config.push']);
    Route::post('push/user1/store', ['uses' => 'AppConfigController@push_user1_store', 'as' => 'config.push_user1_store']);
    Route::post('push/user2/store', ['uses' => 'AppConfigController@push_user2_store', 'as' => 'config.push_user2_store']);

    Route::get('push/send', ['uses' => 'AppConfigController@send_create', 'as' => 'config.send_create']);
    Route::post('push/send', ['uses' => 'AppConfigController@send', 'as' => 'config.send']);

    Route::get('translation', ['uses' => 'AppConfigController@translation', 'as' => 'config.translation']);
    Route::post('translation', ['uses' => 'AppConfigController@translationStore', 'as' => 'config.translationStore']);
    Route::post('translation/{id}/update', ['uses' => 'AppConfigController@translationUpdate', 'as' => 'config.translationUpdate']);
    Route::get('translation/{id}/remove', ['uses' => 'AppConfigController@translationRemove', 'as' => 'config.translationRemove']);

    
    Route::get('contactUs', [ 'as' => 'admin.contactUs.index', 'uses' => 'ContactUsController@index' ]);
    Route::get('contactUs/create', [ 'as' => 'admin.contactUs.create', 'uses' => 'ContactUsController@create' ]);
    Route::post('contactUs', [ 'as' => 'admin.contactUs.store', 'uses' => 'ContactUsController@store' ]);
    Route::get('contactUs/{id}', [ 'as' => 'admin.contactUs.show', 'uses' => 'ContactUsController@show' ]);
    Route::get('contactUs/{id}/edit', [ 'as' => 'admin.contactUs.edit', 'uses' => 'ContactUsController@edit' ]);
    Route::put('contactUs/{id}', [ 'as' => 'admin.contactUs.update', 'uses' => 'ContactUsController@update' ]);
    Route::get('contactUs/{id}/destroy', [ 'as' => 'admin.contactUs.delete', 'uses' => 'ContactUsController@destroy' ]);



    Route::get('customerChats/{contactId}', [ 'as' => 'admin.customerChats.index', 'uses' => 'CustomerChatController@index' ]);
    Route::get('customerChats/{contactId}/create', [ 'as' => 'admin.customerChats.create', 'uses' => 'CustomerChatController@create' ]);
    Route::post('customerChats', [ 'as' => 'admin.customerChats.store', 'uses' => 'CustomerChatController@store' ]);
    Route::get('customerChats/{id}', [ 'as' => 'admin.customerChats.show', 'uses' => 'CustomerChatController@show' ]);
    Route::get('customerChats/{id}/edit', [ 'as' => 'admin.customerChats.edit', 'uses' => 'CustomerChatController@edit' ]);
    Route::put('customerChats/{id}', [ 'as' => 'admin.customerChats.update', 'uses' => 'CustomerChatController@update' ]);
    Route::get('customerChats/{id}/destroy', [ 'as' => 'admin.customerChats.delete', 'uses' => 'CustomerChatController@destroy' ]);

    Route::get('chat', [ 'as' => 'admin.chat.index', 'uses' => 'ChatController@index' ]);

    // Route::get('search/states', [ 'as' => 'admin.states.search', 'uses' => 'StateController@search' ]);
    Route::get('search/cities', [ 'as' => 'admin.cities.search', 'uses' => 'UserController@searchCities' ]);
    

    Route::get('chats', [ 'as' => 'admin.chats.index', 'uses' => 'ChatController@index' ]);
    Route::get('chats/{id}', [ 'as' => 'admin.chats.show', 'uses' => 'ChatController@show' ]);
    // Route::get('chats/{id}/destroy', [ 'as' => 'admin.chats.delete', 'uses' => 'ChatController@destroy' ]);
    Route::post('chats/logs/store', ['as' => 'admin.chats.logStore', 'uses' => 'ChatController@logStore']);


    Route::get('brands', [ 'as' => 'admin.brands.index', 'uses' => 'BrandController@index' ]);
    Route::get('brands/create', [ 'as' => 'admin.brands.create', 'uses' => 'BrandController@create' ]);
    Route::post('brands', [ 'as' => 'admin.brands.store', 'uses' => 'BrandController@store' ]);
    Route::get('brands/{id}', [ 'as' => 'admin.brands.show', 'uses' => 'BrandController@show' ]);
    Route::get('brands/{id}/edit', [ 'as' => 'admin.brands.edit', 'uses' => 'BrandController@edit' ]);
    Route::put('brands/{id}', [ 'as' => 'admin.brands.update', 'uses' => 'BrandController@update' ]);
    Route::get('brands/{id}/destroy', [ 'as' => 'admin.brands.delete', 'uses' => 'BrandController@destroy' ]);

    Route::get('segments', [ 'as' => 'admin.segments.index', 'uses' => 'SegmentController@index' ]);
    Route::get('segments/create', [ 'as' => 'admin.segments.create', 'uses' => 'SegmentController@create' ]);
    Route::post('segments', [ 'as' => 'admin.segments.store', 'uses' => 'SegmentController@store' ]);
    Route::get('segments/{id}', [ 'as' => 'admin.segments.show', 'uses' => 'SegmentController@show' ]);
    Route::get('segments/{id}/edit', [ 'as' => 'admin.segments.edit', 'uses' => 'SegmentController@edit' ]);
    Route::put('segments/{id}', [ 'as' => 'admin.segments.update', 'uses' => 'SegmentController@update' ]);
    Route::get('segments/{id}/destroy', [ 'as' => 'admin.segments.delete', 'uses' => 'SegmentController@destroy' ]);

    Route::get('requisitions/create', ['as' => 'admin.requisitions.create', 'uses' => 'RequisitionController@create']);
});

Route::get('logs', function(){

    if( request('clear') ) {
        \DB::table('api_logs')->truncate();
        return Redirect::to('logs');
    }

    return view('logs');
});