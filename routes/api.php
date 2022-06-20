<?php
namespace App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\Buyer\BuyersController;
use App\Http\Controllers\Seller\SellersController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Buyer\BuyerSellersController;
use App\Http\Controllers\Buyer\BuyerProductsController;
use App\Http\Controllers\Category\CategoriesController;
use App\Http\Controllers\Seller\SellerBuyersController;
use App\Http\Controllers\Buyer\BuyerCategoriesController;
use App\Http\Controllers\Seller\SellerProductsController;
use App\Http\Controllers\Category\CategoryBuyersController;
use App\Http\Controllers\Seller\SellerCategoriesController;
use App\Http\Controllers\Category\CategorySellersController;
use App\Http\Controllers\Transaction\TransactionsController;
use App\Http\Controllers\Category\CategoryProductsController;
use App\Http\Controllers\Seller\SellerTransactionsController;
use App\Http\Controllers\Category\CategoryTransactionsController;
use App\Http\Controllers\Transaction\TransactionSellersController;
use App\Http\Controllers\Transaction\TransactionCategoryController;

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

Route::resource('users', UsersController::class);
Route::resource('buyers', BuyersController::class);
Route::resource('sellers', SellersController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('products', ProductsController::class);
Route::resource('transactions', TransactionsController::class);
Route::resource('transactions.categories', TransactionCategoryController::class);
Route::resource('transactions.sellers', TransactionSellersController::class);

Route::resource('buyers.products', BuyerProductsController::class);
Route::resource('buyers.sellers', BuyerSellersController::class);
Route::resource('buyers.categories', BuyerCategoriesController::class);

Route::resource('categories.buyers',CategoryBuyersController::class);
Route::resource('categories.products',CategoryProductsController::class);
Route::resource('categories.sellers',CategorySellersController::class);
Route::resource('categories.transactions',CategoryTransactionsController::class);

Route::resource('sellers.transactions',SellerTransactionsController::class);
Route::resource('sellers.buyers',SellerBuyersController::class);
Route::resource('sellers.products',SellerProductsController::class);
Route::resource('sellers.categories',SellerCategoriesController::class);


