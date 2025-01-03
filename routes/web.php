<?php

use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CapController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\HargaPasaranController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\JenisPerhiasanController;
use App\Http\Controllers\MainanController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SuratPembelianController;
use App\Http\Controllers\TipePerhiasanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
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

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/choose_action', 'choose_action')->name('choose_action');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate')->name('authenticate')->middleware('guest');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'register_new')->name('register_new');
});

Route::controller(PelangganController::class)->group(function () {
    Route::get('/pelanggans/index', 'index')->name('pelanggans.index')->middleware('level3');
    Route::get('/pelanggans/create', 'pelanggans_create')->name('pelanggans.create')->middleware('level3');
    Route::post('/pelanggans/store', 'pelanggans_store')->name('pelanggans.store')->middleware('level3');
    Route::get('/pelanggans/{pelanggan}/show', 'show')->name('pelanggans.show')->middleware('level3');
    Route::get('/pelanggans/{pelanggan}/edit', 'edit')->name('pelanggans.edit')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/update', 'update')->name('pelanggans.update')->middleware('level3');
    Route::get('/pelanggans/{pelanggan}/edit_profile_picture', 'edit_profile_picture')->name('pelanggans.edit_profile_picture')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/update_profile_picture', 'update_profile_picture')->name('pelanggans.update_profile_picture')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/update_id_photo', 'update_id_photo')->name('pelanggans.update_id_photo')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/delete_profile_picture', 'delete_profile_picture')->name('pelanggans.delete_profile_picture')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/delete_id_photo', 'delete_id_photo')->name('pelanggans.delete_id_photo')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/delete', 'delete')->name('pelanggans.delete')->middleware('level3');
    Route::get('/pelanggans/{pelanggan}/list_of_items', 'list_of_items')->name('pelanggans.list_of_items')->middleware('level3');
    Route::get('/pelanggans/{pelanggan}/change_password', 'change_password')->name('pelanggans.change_password')->middleware('level3');
    Route::post('/pelanggans/{pelanggan}/update_password', 'update_password')->name('pelanggans.update_password')->middleware('level3');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users/index', 'index')->name('users.index')->middleware('level3');
    Route::get('/users/create', 'users_create')->name('users.create')->middleware('level5');
    Route::post('/users/store', 'users_store')->name('users.store')->middleware('level5');
    Route::get('/users/{user_this}/show', 'show')->name('users.show')->middleware('level3');
    // Route::get('/users/{user}/profile', 'profile')->name('users.profile')->middleware('level3');
    Route::get('/users/{user_this}/edit', 'edit')->name('users.edit')->middleware('level3');
    Route::post('/users/{user_this}/update', 'update')->name('users.update')->middleware('level3');
    Route::get('/users/{user_this}/edit_profile_picture', 'edit_profile_picture')->name('users.edit_profile_picture')->middleware('level3');
    Route::post('/users/{user_this}/update_profile_picture', 'update_profile_picture')->name('users.update_profile_picture')->middleware('level3');
    Route::post('/users/{user_this}/update_id_photo', 'update_id_photo')->name('users.update_id_photo')->middleware('level3');
    Route::post('/users/{user_this}/delete_profile_picture', 'delete_profile_picture')->name('users.delete_profile_picture')->middleware('level3');
    Route::post('/users/{user_this}/delete_id_photo', 'delete_id_photo')->name('users.delete_id_photo')->middleware('level3');
    Route::post('/users/{user_this}/delete', 'delete')->name('users.delete')->middleware('level3');
    Route::get('/users/{user_this}/list_of_items', 'list_of_items')->name('users.list_of_items')->middleware('level3');
    Route::get('/users/{user_this}/change_password', 'change_password')->name('users.change_password')->middleware('level3');
    Route::post('/users/{user_this}/update_password', 'update_password')->name('users.update_password')->middleware('level3');
});

Route::controller(ItemController::class)->group(function () {
    Route::get('/items/pilih_tipe_barang', 'pilih_tipe_barang')->name('add_new_item.pilih_tipe_barang')->middleware('level3');
    Route::get('/items/{tipe_barang}/create_item', 'create_item')->name('add_new_item.create')->middleware('level3');
    Route::post('/items/store', 'store')->name('items.store')->middleware('level3');
    Route::get('/items/{item}/show', 'show')->name('items.show')->middleware('auth');
    Route::get('/items/{item}/edit', 'edit')->name('items.edit')->middleware('level3');
    Route::post('/items/{item}/update', 'update')->name('items.update')->middleware('level3');
    Route::post('/items/{item}/delete', 'delete')->name('items.delete')->middleware('level3');
    Route::post('/items/{item}/{item_photo}/{photo}/delete_photo', 'delete_photo')->name('items.delete_photo')->middleware('level3');
    Route::get('/items/{item}/add_photo', 'add_photo')->name('items.add_photo')->middleware('level3');
    Route::get('/items/{item}/{index}/pilihan_photo', 'pilihan_photo')->name('items.pilihan_photo')->middleware('level3');
    Route::post('/items/{item}/update_stock', 'update_stock')->name('items.update_stock')->middleware('level3');
    Route::get('/items/{item}/{similar_item}/link_photo_from_similar_item', 'link_photo_from_similar_item')->name('items.link_photo_from_similar_item')->middleware('level3');
    // Route::post('/items/{item}/mau','mau')->name('items.mau');
    // Route::post('/items/{item}/{peminat_item}/hapus_peminat','hapus_peminat')->name('items.hapus_peminat');
});

Route::controller(PhotoController::class)->group(function () {
    Route::post('/items/{item}/add_photo', 'add_photo')->name('items.add_photo')->middleware('level3');
    Route::post('/items/{item}/{item_photo}/{photo}/delete_photo', 'delete_photo')->name('items.delete_photo')->middleware('level3');
    Route::post('/items/{item}/add_photo_from_sugestion', 'add_photo_from_sugestion')->name('items.add_photo_from_sugestion')->middleware('level3');
    Route::post('/photos/{cart_item}/add_cart_item_photo', 'add_cart_item_photo')->name('photos.add_cart_item_photo')->middleware('level3');
    Route::post('/photos/{cart_item}/delete_cart_item_photo', 'delete_cart_item_photo')->name('photos.delete_cart_item_photo')->middleware('level3');
    Route::post('/photos/{cart}/add_cart_photo', 'add_cart_photo')->name('photos.add_cart_photo')->middleware('level3');
    Route::post('/photos/{cart}/delete_cart_photo', 'delete_cart_photo')->name('photos.delete_cart_photo')->middleware('level3');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/carts/{user}/index', 'index')->name('carts.index')->middleware('level3');
    Route::get('/carts/{cart}/checkout', 'checkout')->name('carts.checkout')->middleware('level3');
    Route::post('/carts/{cart}/proses_checkout', 'proses_checkout')->name('carts.proses_checkout')->middleware('level3');
    Route::post('/carts/{item}/{user}/insert_to_cart', 'insert_to_cart')->name('carts.insert_to_cart')->middleware('level3');
    // Route::post('/carts/{cart}/delete_cart_photo','delete_cart_photo')->name('photos.delete_cart_photo')->middleware('level3');
});

Route::controller(CartItemController::class)->group(function () {
    Route::get('/cart_items/{cart}/{cart_item}/add_photo', 'add_photo')->name('cart_items.add_photo')->middleware('level3');
    Route::post('/cart_items/{cart}/{cart_item}/delete', 'delete')->name('cart_items.delete')->middleware('level3');
});

Route::controller(SuratPembelianController::class)->group(function () {
    Route::get('/surat_pembelian/index', 'index')->name('surat_pembelian.index')->middleware('level3');
    Route::get('/surat_pembelian/{surat_pembelian}/show', 'show')->name('surat_pembelian.show')->middleware('level3');
    Route::post('/surat_pembelian/{surat_pembelian}/update_data_pelanggan', 'update_data_pelanggan')->name('surat_pembelian.update_data_pelanggan')->middleware('level5');
    Route::get('/surat_pembelian/{surat_pembelian}/print_out', 'print_out')->name('surat_pembelian.print_out')->middleware('level3');
    Route::get('/surat_pembelian/{surat_pembelian}/delete', 'delete')->name('surat_pembelian.delete')->middleware('level5');
    Route::post('/surat_pembelian/{surat_pembelian}/delete_photo', 'delete_photo')->name('surat_pembelian.delete_photo')->middleware('level5');
    Route::post('/surat_pembelian/{surat_pembelian}/update_photo', 'update_photo')->name('surat_pembelian.update_photo')->middleware('level3');
    Route::get('/surat_pembelian/{surat_pembelian}/buyback', 'buyback')->name('surat_pembelian.buyback')->middleware('level3');
    Route::post('/surat_pembelian/{surat_pembelian}/proses_buyback', 'proses_buyback')->name('surat_pembelian.proses_buyback')->middleware('level3');
    Route::get('/surat_pembelian/{surat_pembelian}/{surat_pembelian_item}/cancel_buyback', 'cancel_buyback')->name('surat_pembelian.cancel_buyback')->middleware('level3');
    Route::post('/surat_pembelian/{surat_pembelian}/{surat_pembelian_item}/proceed_cancel_buyback', 'proceed_cancel_buyback')->name('surat_pembelian.proceed_cancel_buyback')->middleware('level5');
    Route::post('/surat_pembelian/{surat_pembelian}/delete_customer', 'delete_customer')->name('surat_pembelian.delete_customer')->middleware('level3');
});

Route::controller(CashflowController::class)->group(function () {
    Route::get('/cashflow/index', 'index')->name('cashflow.index')->middleware('level3');
    Route::get('/cashflow/transaksi/{tipe_transaksi}', 'transaksi')->name('cashflow.transaksi')->middleware('level3');
    Route::post('/cashflow/store_transaction', 'store_transaction')->name('cashflow.store_transaction')->middleware('level3');
    Route::post('/cashflow/update_saldo_wallet', 'update_saldo_wallet')->name('cashflow.update_saldo_wallet')->middleware('level5');
    Route::get('/cashflow/found_similar_items', 'found_similar_items')->name('cashflow.found_similar_items')->middleware('level3');
    // Route::post('/cashflow/store_and_buyback_perhiasan', 'store_and_buyback_perhiasan')->name('cashflow.store_and_buyback_perhiasan')->middleware('level3');
});

Route::controller(TransactionController::class)->group(function () {
    Route::get('/transactions/found_similar_items', 'found_similar_items')->name('transactions.found_similar_items')->middleware('level3');
    Route::get('/transactions/{user}/rincian_transaksi', 'rincian_transaksi')->name('transactions.rincian_transaksi')->middleware('level3');
});

// ATTRIBUTES
Route::get('/attributes/index', function () { 
    $user = Auth::user();
    $cart = null;
    if ($user) {
        $cart = Cart::where('user_id', $user->id)->first();
    }
    $data = [
        'cart' => $cart,
        'user' => $user,
    ];
    return view('attributes.index', $data);
})->name('attributes.index')->middleware('level3');
// HARGA PASARAN
Route::controller(HargaPasaranController::class)->group(function(){
    Route::get('/attributes/harga_pasaran/index','index')->name('attributes.harga_pasaran.index')->middleware('level3');
    Route::get('/attributes/harga_pasaran/create','create')->name('attributes.harga_pasaran.create')->middleware('level3');
    Route::post('/attributes/harga_pasaran/store','store')->name('attributes.harga_pasaran.store')->middleware('level3');
    Route::get('/attributes/harga_pasaran/{harga_pasaran}/edit','edit')->name('attributes.harga_pasaran.edit')->middleware('level3');
    Route::post('/attributes/harga_pasaran/{harga_pasaran}/update','update')->name('attributes.harga_pasaran.update')->middleware('level3');
    Route::post('/attributes/harga_pasaran/{harga_pasaran}/destroy','destroy')->name('attributes.harga_pasaran.destroy')->middleware('level5');
});

// TIPE PERHIASAN
Route::controller(TipePerhiasanController::class)->group(function(){
    Route::get('/attributes/tipe_perhiasans/index','index')->name('attributes.tipe_perhiasans.index')->middleware('level3');
    Route::get('/attributes/tipe_perhiasans/create','create')->name('attributes.tipe_perhiasans.create')->middleware('level3');
    Route::post('/attributes/tipe_perhiasans/store','store')->name('attributes.tipe_perhiasans.store')->middleware('level3');
    Route::get('/attributes/tipe_perhiasans/{tipe_perhiasan}/edit','edit')->name('attributes.tipe_perhiasans.edit')->middleware('level3');
    Route::post('/attributes/tipe_perhiasans/{tipe_perhiasan}/update','update')->name('attributes.tipe_perhiasans.update')->middleware('level3');
    Route::post('/attributes/tipe_perhiasans/{tipe_perhiasan}/destroy','destroy')->name('attributes.tipe_perhiasans.destroy')->middleware('level5');
});

// JENIS PERHIASAN
Route::controller(JenisPerhiasanController::class)->group(function(){
    Route::get('/attributes/jenis_perhiasans/index','index')->name('attributes.jenis_perhiasans.index')->middleware('level3');
    Route::get('/attributes/jenis_perhiasans/create','create')->name('attributes.jenis_perhiasans.create')->middleware('level3');
    Route::post('/attributes/jenis_perhiasans/store','store')->name('attributes.jenis_perhiasans.store')->middleware('level3');
    Route::get('/attributes/jenis_perhiasans/{jenis_perhiasan}/edit','edit')->name('attributes.jenis_perhiasans.edit')->middleware('level3');
    Route::post('/attributes/jenis_perhiasans/{jenis_perhiasan}/update','update')->name('attributes.jenis_perhiasans.update')->middleware('level3');
    Route::post('/attributes/jenis_perhiasans/{jenis_perhiasan}/destroy','destroy')->name('attributes.jenis_perhiasans.destroy')->middleware('level5');
});

// MERK
Route::controller(MerkController::class)->group(function(){
    Route::get('/attributes/merks/index','index')->name('attributes.merks.index')->middleware('level3');
    Route::get('/attributes/merks/create','create')->name('attributes.merks.create')->middleware('level3');
    Route::post('/attributes/merks/store','store')->name('attributes.merks.store')->middleware('level3');
    Route::get('/attributes/merks/{merk}/edit','edit')->name('attributes.merks.edit')->middleware('level3');
    Route::post('/attributes/merks/{merk}/update','update')->name('attributes.merks.update')->middleware('level3');
    Route::post('/attributes/merks/{merk}/destroy','destroy')->name('attributes.merks.destroy')->middleware('level5');
});

// MAINAN
Route::controller(MainanController::class)->group(function(){
    Route::get('/attributes/mainans/index','index')->name('attributes.mainans.index')->middleware('level3');
    Route::get('/attributes/mainans/create','create')->name('attributes.mainans.create')->middleware('level3');
    Route::post('/attributes/mainans/store','store')->name('attributes.mainans.store')->middleware('level3');
    Route::get('/attributes/mainans/{mainan}/edit','edit')->name('attributes.mainans.edit')->middleware('level3');
    Route::post('/attributes/mainans/{mainan}/update','update')->name('attributes.mainans.update')->middleware('level3');
    Route::post('/attributes/mainans/{mainan}/destroy','destroy')->name('attributes.mainans.destroy')->middleware('level5');
});

// CAP
Route::controller(CapController::class)->group(function(){
    Route::get('/attributes/caps/index','index')->name('attributes.caps.index')->middleware('level3');
    Route::get('/attributes/caps/create','create')->name('attributes.caps.create')->middleware('level3');
    Route::post('/attributes/caps/store','store')->name('attributes.caps.store')->middleware('level3');
    Route::get('/attributes/caps/{cap}/edit','edit')->name('attributes.caps.edit')->middleware('level3');
    Route::post('/attributes/caps/{cap}/update','update')->name('attributes.caps.update')->middleware('level3');
    Route::post('/attributes/caps/{cap}/destroy','destroy')->name('attributes.caps.destroy')->middleware('level5');
});
// END - ATTRIBUTES

Route::controller(ArtisanController::class)->group(function () {
    Route::get('/artisans', 'index')->name('artisans.index')->middleware('level5');
    Route::post('/artisans/input_initial_data_warna_emas', 'input_initial_data_warna_emas')->name('artisans.input_initial_data_warna_emas')->middleware('level5');
    Route::post('/artisans/migrate_fresh_seed', 'migrate_fresh_seed')->name('artisans.migrate_fresh_seed')->middleware('level5');
    Route::post('/artisans/symbolic_link', 'symbolic_link')->name('artisans.symbolic_link')->middleware('level5');
    Route::post('/artisans/optimize_clear', 'optimize_clear')->name('artisans.optimize_clear')->middleware('level5');
    Route::post('/artisans/update_codename_in_table_matas', 'update_codename_in_table_matas')->name('artisans.update_codename_in_table_matas')->middleware('level5');
    Route::post('/artisans/update_codename_in_table_mainans', 'update_codename_in_table_mainans')->name('artisans.update_codename_in_table_mainans')->middleware('level5');
    Route::post('/artisans/backup_data', 'backup_data')->name('artisans.backup_data')->middleware('level5');
    Route::post('/artisans/update_jenis_perhiasans_d_caps', 'update_jenis_perhiasans_d_caps')->name('artisans.update_jenis_perhiasans_d_caps')->middleware('level5');
    // Route::post('/artisans/vendor_publish_laravelPWA','vendor_publish_laravelPWA')->name('artisans.vendor_publish_laravelPWA')->middleware('auth');
});
