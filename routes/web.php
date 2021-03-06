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

// VISITORS ROUTES
Route::get('/', function () {
    $agents = App\User::all()->take(6);
    return view('welcome',[
        "agents" => $agents
    ]);
});


// Agents search
Route::get('/agents', "UserController@search_form")->name('agents.show_all');

Route::post('/agents', "UserController@search")->name('agents.search');
Route::post('/agents_search_name', "UserController@agents_search_name")->name('agents.search_name');



// agent profile
Route::get('agent/{user}',"UserController@show")->name('agent.show_profile');

// Booking Process
Route::get('agent/{user}/book',"BookingController@create")->name('booking.show_form');
// Booking info
Route::post('/agent/{user}/book', "BookingController@store_info")->name('booking.store.info');
// Booking meal
Route::post('booking/{booking}/meal', "BookingController@store_meal")->name('booking.store.meal');
// Booking payment
Route::get('booking/{booking}/payment', "BookingController@show_payment")->name('booking.store.payment_form');
Route::post('booking/{booking}/payment', "BookingController@store_payment")->name('booking.store.payment');

// Rating and review
Route::post('booking/{booking}/review', "BookingController@store_review")->name('booking.store.review');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/message', 'MessageController@store')->name('message.store');
/*

    PHOTOS ROUTES

*/
// get photo
Route::get('/photo/{photo}', 'PhotoController@show')->name('photo.get');
Route::get('/default_photo', 'PhotoController@show_default')->name('photo.default');


/*

    SUPER ADMIN ROUTES

*/
Route::prefix('admin')->middleware(['admin'])->group(function () {
    
    // Agents routes
    Route::resource('agent', 'UserController');

    // Services routes
    Route::resource('service', 'ServiceController');

    // messages
    Route::get('/messages', 'MessageController@index')->name('message.index');

    // Booking routes
    Route::get('bookings', 'BookingController@index_admin')->name('booking.index_admin');
    // Booking filter
    Route::post('bookings', 'BookingController@filter')->name('booking.filter');
});

/*

AGENT ADMIN ROUTES

*/


Route::middleware(['agent_admin'])->group(function () {
    
    // Booking routes
    Route::get('bookings', 'BookingController@index')->name('booking.index');
    // Booking routes
    Route::get('bookings/complete', 'BookingController@complete')->name('booking.complete');
    // Booking routes
    Route::get('bookings/requested', 'BookingController@requested')->name('booking.requested');

    // Prices routes
    Route::resource('price', 'PriceController');

     // Meals routes
     Route::resource('meal', 'MealController');


    //  Profile reotues
    Route::get('/profile/edit', 'UserController@edit_profile')->name('agent.edit_profile');

    //  Show Calendar
    Route::get('/calendar', 'BookingController@calendar')->name('agent.calendar');

    Route::post('/profile/update_info', 'UserController@update_info')->name('agent.update_info');
    Route::post('/profile/add_photo', 'UserController@add_photo')->name('agent.add_photo');
    
});



