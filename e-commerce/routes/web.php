<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomesController;

Route::resource('kategori', KategoriController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('produk', ProdukController::class);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::middleware(['auth'])->group(function () {

Route::get('/produks', [ProdukController::class, 'indexPelanggan'])->name('produk.indexPelanggan');

// Route for buying (checkout)
Route::get('produks/{id}', [ProdukController::class, 'showPelanggan'])->name('produk.showPelanggan');

Route::get('/search', [ProdukController::class, 'search'])->name('produk.search');


Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
Route::get('homes', [HomesController::class, 'index'])->name('homes');
//});
   

Route::get('/kontak-kami', [ContactController::class, 'index'])->name('contact.index');

//Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    //Route::resource('kategori', KategoriController::class);
    //Route::resource('pelanggan', PelangganController::class);
    //Route::resource('produk', ProdukController::class);
    Route::resource('transaksi', TransaksiController::class);
//});
//Route::middleware(['auth'])->group(function () {

    Route::post('/produks/{id}/keranjang', [ProdukController::class, 'keranjang'])->name('produk.keranjang');

    Route::get('/produks/{id}/keranjang', [ProdukController::class, 'keranjang'])->name('produk.keranjang');
    Route::post('/produk/checkout', [ProdukController::class, 'checkout'])->name('produk.checkout');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');

    // Route to add a product to the cart
    Route::post('/keranjang/{id}/add', [KeranjangController::class, 'add'])->name('keranjang.add');
    
    // Route to remove a product from the cart
    Route::delete('/keranjang/{id}/remove', [KeranjangController::class, 'remove'])->name('keranjang.remove');

    Route::get('checkouttt', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkouttt/add/{id}', [CheckoutController::class, 'add'])->name('checkout.add');
    Route::delete('checkouttt/remove/{id}', [CheckoutController::class, 'remove'])->name('checkout.remove');
    Route::get('checkouttt/cities', [CheckoutController::class, 'getCities'])->name('checkout.getCities');
    Route::get('checkouttt/shipping', [CheckoutController::class, 'getShippingServices'])->name('checkout.getShippingServices');
    Route::post('checkouttt/ongkir', [CheckoutController::class, 'checkOngkir'])->name('checkout.checkOngkir');
    Route::get('checkout/ongkir/services', [CheckoutController::class, 'getServices'])->name('checkout.getServices');

//});