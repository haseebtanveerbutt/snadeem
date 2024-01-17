<?php

use App\Http\Controllers\AppAdminController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\WidgetSettingController;
use App\Http\Controllers\WizardCOntroller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['verify.shopify']], function () {

//    Route::get('/', [AppAdminController::class, 'dashboard'])->name('home');

    Route::get('/', [OrderController::class, 'index'])->name('home');
    Route::get('/fulfillment-on-system/{id}', [OrderController::class, 'fulfillment_on_system'])->name('fulfillment_on_system');
    Route::get('/sync_orders', [OrderController::class, 'sync_orders'])->name('sync-orders');
    Route::get('/sync_shipments', [OrderController::class, 'sync_shipments'])->name('sync-shipments');
    Route::get('/settings', [OrderController::class, 'settings'])->name('settings');
    Route::any('/setting_save', [OrderController::class, 'setting_save'])->name('setting_save');

    Route::get('/get_inventory_levels', [OrderController::class, 'get_inventory_levels'])->name('get_inventory_levels');

    Route::get('/filter/orders/{shop_id}', [OrderController::class, 'filter_orders'])->name('filter.orders');
    Route::get('/filter/search/orders/{shop_id}', [OrderController::class, 'filter_search_orders'])->name('filter.search.orders');

    Route::get('help', [AppAdminController::class, 'help'])->name('help');

    Route::post('/save_location', [OrderController::class, 'save_location'])->name('save.location');
    Route::post('/edit_save_location/{id}', [OrderController::class, 'edit_save_location'])->name('edit.save.location');

    Route::get('delete_location/{id}', [OrderController::class, 'delete_location'])->name('delete.location');

    Route::get('manual/email/order/fulfillment', [OrderController::class, 'email_order_fulfillment'])->name('email.order.fulfillment');
    Route::get('manual/email/order/pickup', [OrderController::class, 'email_order_pickup'])->name('email.order.pickup');

});

Route::get('/email/order/fulfillment', [OrderController::class, 'email_order_fulfillment']);
Route::get('/email/order/pickup', [OrderController::class, 'email_order_pickup']);

Auth::routes();
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {

    Route::get('/', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/shops', [HomeController::class, 'shop_index'])->name('shops');
    Route::get('/shop/detail/{id}', [HomeController::class, 'shop_status_detail'])->name('shop-status-detail');
    Route::post('shop/detail/save', [HomeController::class, 'shop_status_detail_save'])->name('shop-status-detail-save');
    Route::get('/StatusSave', [HomeController::class, 'StatusSave'])->name('StatusSave');

    Route::get('/orders', [OrderController::class, 'admin_all_orders'])->name('admin.all.orders');
    Route::get('/shop/{id}', [OrderController::class, 'admin_orders'])->name('admin.orders');
    Route::get('/order/detail/{id}', [OrderController::class, 'admin_order_detail'])->name('admin.order.detail');
    Route::get('/filter/admin/orders/{shop_id}', [OrderController::class, 'filter_admin_orders'])->name('filter.admin.orders');
    Route::get('/filter/search/orders/{shop_id}', [OrderController::class, 'admin_filter_search_orders'])->name('admin.filter.search.orders');
    Route::get('/filter/search/all/orders', [OrderController::class, 'admin_filter_search_all_orders'])->name('admin.filter.search.all.orders');

});

Route::any('/privacy', [OrderController::class, 'privacy'])->name('app.privacy');

Route::get('register/webhooks',function (){
    $user = User::first();
dd(2);
    $data = [
        "webhook" => [
            "topic" => "orders/create",
            "address" => env("APP_URL")."/api/webhook/orders-create",
            "format" => "json",
        ]
    ];
    $res = $user->api()->rest('POST', '/admin/api/2023-04/webhooks.json', $data, [], true);

    $data = [
        "webhook" => [
            "topic" => "orders/update",
            "address" => env("APP_URL")."/api/webhook/orders-update",
            "format" => "json",
        ]
    ];
    $res2 =$user->api()->rest('POST', '/admin/api/2023-04/webhooks.json', $data, [], true);
dd($res,$res2);
});

Route::get('webhooks', function (Request $request) {
    $shop = \App\Models\User::first();

    $webhooks = $shop->api()->rest('get', '/admin/api/2023-04/webhooks');
    dd($webhooks);
    return response()->json($webhooks);
})->name('webhook');

