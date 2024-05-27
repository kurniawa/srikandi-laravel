<?php

use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SuratPembelianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', function () {
    return view('test');
});

Route::controller(HomeController::class)->group(function(){
    Route::get('/','home')->name('home');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/login','login')->name('login');
    Route::post('/login','authenticate')->name('authenticate');
    Route::post('/logout','logout')->name('logout');
    Route::get('/register','register')->name('register');
    Route::post('/register','register_new')->name('register_new');
});

Route::controller(UserController::class)->group(function(){
    Route::get('/pelanggans/index','index')->name('pelanggans.index')->middleware('level3');
    Route::get('/pelanggans/create','pelanggans_create')->name('pelanggans.create')->middleware('level3');
    Route::post('/pelanggans/store','pelanggans_store')->name('pelanggans.store')->middleware('level3');
    Route::get('/pelanggans/{pelanggan}/show','show')->name('pelanggans.show')->middleware('level3');
    Route::get('/pelanggans/{pelanggan}/edit','edit')->name('pelanggans.edit')->middleware('level3');
    Route::get('/pelanggans/{pelanggan}/edit_profile_picture','edit_profile_picture')->name('pelanggans.edit_profile_picture')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/update_profile_picture','update_profile_picture')->name('pelanggans.update_profile_picture')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/update_id_photo','update_id_photo')->name('pelanggans.update_id_photo')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/delete_profile_picture','delete_profile_picture')->name('pelanggans.delete_profile_picture')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/delete_id_photo','delete_id_photo')->name('pelanggans.delete_id_photo')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/delete','delete')->name('pelanggans.delete')->middleware('level3');
    Route::get('/users/{user}/list_of_items','list_of_items')->name('users.list_of_items')->middleware('level3');

});

Route::controller(ItemController::class)->group(function(){
    Route::get('/items/{from}/pilih_tipe_barang','pilih_tipe_barang')->name('add_new_item.pilih_tipe_barang')->middleware('level3');
    Route::get('/items/{from}/{tipe_barang}/create_item','create_item')->name('add_new_item.create')->middleware('level3');
    Route::post('/items/{from}/store','store')->name('items.store')->middleware('level3');
    Route::get('/items/{item}/{from}/show','show')->name('items.show')->middleware('auth');
    Route::get('/items/{item}/edit','edit')->name('items.edit')->middleware('level3');
    Route::post('/items/{item}/update','update')->name('items.update')->middleware('level3');
    Route::post('/items/{item}/delete','delete')->name('items.delete')->middleware('level3');
    Route::post('/items/{item}/{item_photo}/{photo}/delete_photo','delete_photo')->name('items.delete_photo')->middleware('level3');
    Route::get('/items/{item}/add_photo','add_photo')->name('items.add_photo')->middleware('level3');
    // Route::post('/items/{item}/mau','mau')->name('items.mau');
    // Route::post('/items/{item}/{peminat_item}/hapus_peminat','hapus_peminat')->name('items.hapus_peminat');
});

Route::controller(PhotoController::class)->group(function(){
    Route::post('/items/{item}/add_photo','add_photo')->name('items.add_photo')->middleware('level3');
    Route::post('/items/{item}/{item_photo}/{photo}/delete_photo','delete_photo')->name('items.delete_photo')->middleware('level3');
    Route::post('/photos/{cart_item}/add_cart_item_photo','add_cart_item_photo')->name('photos.add_cart_item_photo')->middleware('level3');
    Route::post('/photos/{cart_item}/delete_cart_item_photo','delete_cart_item_photo')->name('photos.delete_cart_item_photo')->middleware('level3');
    Route::post('/photos/{cart}/add_cart_photo','add_cart_photo')->name('photos.add_cart_photo')->middleware('level3');
    Route::post('/photos/{cart}/delete_cart_photo','delete_cart_photo')->name('photos.delete_cart_photo')->middleware('level3');
});

Route::controller(CartController::class)->group(function(){
    Route::get('/carts/{user}/index','index')->name('carts.index')->middleware('level3');
    Route::get('/carts/{cart}/checkout','checkout')->name('carts.checkout')->middleware('level3');
    Route::post('/carts/{cart}/proses_checkout','proses_checkout')->name('carts.proses_checkout')->middleware('level3');
    Route::post('/carts/{item}/{user}/insert_to_cart','insert_to_cart')->name('carts.insert_to_cart')->middleware('level3');
});

Route::controller(CartItemController::class)->group(function(){
    Route::get('/cart_items/{cart}/{cart_item}/add_photo','add_photo')->name('cart_items.add_photo')->middleware('level3');
    Route::post('/cart_items/{cart}/{cart_item}/delete','delete')->name('cart_items.delete')->middleware('level3');
});

Route::controller(SuratPembelianController::class)->group(function(){
    Route::get('/surat_pembelian/index','index')->name('surat_pembelian.index')->middleware('level3');
    Route::get('/surat_pembelian/{surat_pembelian}/show','show')->name('surat_pembelian.show')->middleware('level3');
    Route::post('/surat_pembelian/{surat_pembelian}/update_data_pelanggan','update_data_pelanggan')->name('surat_pembelian.update_data_pelanggan')->middleware('level3');
    Route::get('/surat_pembelian/{surat_pembelian}/print_out','print_out')->name('surat_pembelian.print_out')->middleware('level3');
    Route::get('/surat_pembelian/{surat_pembelian}/delete','delete')->name('surat_pembelian.delete')->middleware('level3');
});

Route::controller(CashflowController::class)->group(function(){
    Route::get('/cashflow/index','index')->name('cashflow.index')->middleware('level3');
});

Route::controller(ArtisanController::class)->group(function(){
    Route::get('/artisans','index')->name('artisans.index')->middleware('auth');
    Route::post('/artisans/migrate_fresh_seed','migrate_fresh_seed')->name('artisans.migrate_fresh_seed')->middleware('auth');
    Route::post('/artisans/symbolic_link','symbolic_link')->name('artisans.symbolic_link')->middleware('auth');
    Route::post('/artisans/optimize_clear','optimize_clear')->name('artisans.optimize_clear')->middleware('auth');
    // Route::post('/artisans/vendor_publish_laravelPWA','vendor_publish_laravelPWA')->name('artisans.vendor_publish_laravelPWA')->middleware('auth');
});
