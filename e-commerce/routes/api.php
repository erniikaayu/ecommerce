<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\PelangganController;
use App\Http\Controllers\TransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('kategori', KategoriController::class);
Route::apiResource('produk', ProdukController::class);

Route::get('produk-with-category', [ProdukController::class, 'getProductsWithCategory']);
Route::get('kategori-with-total-produk', [KategoriController::class, 'getKategoriWithTotalProduk']);
Route::get('produk-with-total-transaksi', [ProdukController::class, 'getProdukWithTotalTransaksi']);
Route::get('pelanggan-with-total-transaksi', [PelangganController::class, 'getPelangganWithTotalTransaksi']);

 // Route for the Midtrans callback (to handle payment response)
 Route::post('/midtrans/callback', [TransactionController::class, 'callback'])->name('midtrans.callback');
