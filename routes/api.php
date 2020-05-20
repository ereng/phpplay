<?php


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
use Illuminate\Http\Request;

Route::post('/register', 'Auth\APIController@register');
Route::post('/login', 'Auth\APIController@login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Auth\APIController@logout');
    Route::get('/get-user', 'Auth\APIController@getUser');
});
Route::group(['prefix' => 'tpa'], function () {
    Route::post('login', 'ThirdPartyAppAuthController@login');
    Route::post('logout', 'ThirdPartyAppAuthController@logout');
    Route::post('refresh', 'ThirdPartyAppAuthController@refresh');
    Route::post('me', 'ThirdPartyAppAuthController@me');
    Route::post('payload', 'ThirdPartyAppAuthController@payload');
});

Route::group(['middleware' => 'auth:api'], function () {
    // Access Control|Accounts|Permissions|Roles|Assign Permissions|Assign Roles
    Route::group(['middleware' => ['permission:manage_users']], function () {
        Route::resource('permission', 'PermissionController');
        Route::resource('role', 'RoleController');
        Route::get('permissionrole/attach', 'PermissionRoleController@attach');
        Route::get('permissionrole/detach', 'PermissionRoleController@detach');
        Route::get('permissionrole', 'PermissionRoleController@index');
        Route::get('roleuser/attach', 'RoleUserController@attach');
        Route::get('roleuser/detach', 'RoleUserController@detach');
        Route::get('roleuser', 'RoleUserController@index');
    });
    Route::resource('user', 'UserController');
    Route::post('user/image', 'UserController@profilepic');
});

Route::post('medbookresult', 'EmrController@medbookresult');
Route::post('ml4afrikaresult', 'EmrController@ml4afrikaresult');
Route::post('sanitasresult', 'EmrController@sanitasresult');

