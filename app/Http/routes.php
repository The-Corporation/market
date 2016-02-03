<?php
use Illuminate\Http\Request;
use App\District;

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
Route::get('enter', ['uses'=>'AdminController@index']);

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|         here is where all user's route located 
|
*/


Route::get('getDistrict', function () {
   $prov_id=Input::get('prov_id');
   $district=District::where('province_id', '=', $prov_id)->get();
     return Response::json($district);

});
Route::get('getSector', function () {
   $distr_id=Input::get('distr_id');
   $sector=Sector::where('district_id', '=', $distr_id)->get();
     return Response::json($sector);

});

Route::get('getCell', function () {
    $sect_id=Input::get('sect_id');
    $cell=Cell::where('sector_id', '=', $sect_id)->get();
     return Response::json($cell);

});
Route::get('getMarket', function () {
   $cell_id=Input::get('cell_id');
   $mark=Market::where('cell_id', '=', $cell_id)->get();
     return Response::json($mark);

});

Route::get('index',
  ['uses'=>'UserController@index',
  'as'=>'index',
  'middleware'=>['guest'],
  ]);

Route::post('signup',
  ['uses'=>'UserController@signUp',
  'as'=>'signup',
   'middleware'=>['guest'],
  ]);
Route::post('signin',
  ['uses'=>'UserController@signIn',
  'as'=>'signin',
   'middleware'=>['guest'],
  ]);

Route::get('signout',
  ['uses'=>'UserController@signOut',
  'as'=>'signout',

  ]);

Route::get('/save',
  ['uses'=>'UserController@savePrice',
  'as'=>'save',
  ]);
Route::get('price',
  ['uses'=>'UserController@priceRegistration',
  'as'=>'price',
  
  ]);
Route::get('authe',
  ['uses'=>'UserController@authenticated',
  'as'=>'authe',
]);

Route::get('profile',
  ['uses'=>'UserController@profile',
  'as'=>'profile',
  ]);


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|         here is where all Admin's route located 
|
*/
Route::group(['prefix'=>'admin','as' => 'admin.'], function () {

    Route::get('index', ['uses'=>'AdminController@index', 'as'=>'index']);
    Route::get('login', ['uses'=>'AdminController@getSignin', 'as'=>'login']);
    Route::get('logout', ['uses'=>'AdminController@logout', 'as'=>'logout']);
    Route::get('listuser', ['uses'=>'AdminController@listuser', 'as'=>'listuser']);
    Route::get('listcategory', ['uses'=>'AdminController@listcategory', 'as'=>'listcategory']);
    Route::get('message', ['uses'=>'AdminController@getMessage', 'as'=>'message']);
    Route::get('readmessage', ['uses'=>'AdminController@readMessage', 'as'=>'readmessage']);
    Route::get('approve', ['uses'=>'AdminController@approveuser', 'as'=>'approveuser']);
    Route::get('delete', ['uses'=>'AdminController@delete', 'as'=>'delete']);
    Route::get('prices', ['uses'=>'AdminController@getprices', 'as'=>'prices']);
    Route::post('addcategory', ['uses'=>'AdminController@addcategory', 'as'=>'addcategory']);
    Route::post('login', ['uses'=>'AdminController@postSignin', 'as'=>'login']);
    Route::get('test',function(){
      return view('admin.ok');
    });
});



/**
 *
 * Redis and nodejs route for socket.io
 */

Route::get('socket', 'SocketController@index');
Route::post('sendmessage', 'SocketController@sendMessage');
Route::get('writemessage', 'SocketController@writemessage');
