<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InitController;

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
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/get-admin-path', 'admin\GeneralController@get_admin_path');
Route::get('/{page}', 'PageController')->name('page')->where('page', 'about|privacy|terms');

//For Permissions
Route::get('create-permission', [InitController::class, 'initialize']);

require('admin_routes.php');

?>
