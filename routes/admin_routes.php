<?php

use Illuminate\Http\Request;
use App\Http\Controllers\admin\ExportController;

$routeResource = function ($url, $controllerName, $suffix) {
    Route::get($url, $controllerName . '@' . $suffix)->name('admin.' . $suffix);
    Route::get($url . '/create', $controllerName . '@create_' . $suffix)->name('admin.create_' . $suffix);
    Route::post($url . '/create', $controllerName . '@store_' . $suffix);
    Route::get($url . '/edit/{id}', $controllerName . '@edit_' . $suffix)->name('admin.edit_' . $suffix);
    Route::put($url . '/edit/{id}', $controllerName . '@update_' . $suffix);
    Route::delete($url . '/delete', $controllerName . '@destroy_' . $suffix)->name('admin.destroy_' . $suffix);
    Route::get($url . '/export-data', function(Request $request) use($url){
        $exportObject = new ExportController($url);
        return $exportObject->exportData($request);
    });
};

Route::group(['prefix' => config('app.admin_path_name')], function() use ($routeResource) {
    //Login Routes
    Route::get('login', 'Auth\admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\admin\LoginController@login');
    Route::post('logout', 'Auth\admin\LoginController@logout')->name('admin.logout');

    Route::group(['middleware'=> 'auth:admin', 'namespace' => 'admin'],function () use ($routeResource) {
        //Basic Routes
        Route::get('', 'DashboardController@index')->name('admin.home');
        Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
        Route::get('getDashboardUser', 'DashboardController@getUserData');
        Route::post('fetchData', 'GeneralController@get_ajax_data');
        // Ajax Calls
        Route::delete('user/removeMultiple', 'UserController@destroy_multiple_user');
        Route::post('product/getCat', 'CategoryController@get_ajax_category')->name('ajax.getCat');
        Route::post('product/getSubCat', 'CategoryController@get_ajax_subcategory')->name('ajax.getSubCat');
        Route::post('general/getState', 'GeneralController@getState')->name('ajax.getState')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        //Route Resource
        $routeResource("roles", "RoleController", 'roles');
        $routeResource("admin", "AdminController", 'admin');
        $routeResource("category", "CategoryController", 'category');
        $routeResource("subcategory", "CategoryController", 'subcategory');
        $routeResource("product", "ProductController", 'product');
        $routeResource("user", "UserController", 'user');
        $routeResource("pages", "PagesController", 'pages');
        $routeResource("store", "StoreController", 'store');
        $routeResource("banner", "BannerController", 'banner');
    });
});
?>
