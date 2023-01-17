<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\ShoppingBasketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
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

Route::get("/", [ItemController::class, "index"]);

Route::post("/ratings/store/{item}", [RatingsController::class, "store"])->middleware(['auth']);

Route::post("/ratings/update/{item}", [RatingsController::class, "update"])->middleware(['auth']);

Route::post("/ratings/destroy/{item}", [RatingsController::class, "destroy"])->middleware(['auth']);

Route::get("/ratings", [RatingsController::class, "index"])->middleware(['auth']);

Route::get("/items/show/{item}", [ItemController::class, "show"]);

Route::post("/items/sieve", [ItemController::class, "refreshItemsTable"]);

Route::get("/users/register", [UserController::class, "create"])->middleware("guest");

Route::get("/users/edit", [UserController::class, "edit"])->middleware("auth");

Route::post("/users/update/name", [UserController::class, "updateName"])->middleware("auth");

Route::post("/users/update/email", [UserController::class, "updateEmail"])->middleware("auth");

Route::post("/users/update/password", [UserController::class, "updatePassword"])->middleware("auth");

Route::post("/users/authenticate", [UserController::class, "authenticate"])->middleware("guest");

Route::post("/users/destroy", [UserController::class, "destroy"])->middleware("auth");

Route::post("/users/store", [UserController::class, "store"])->middleware("guest");

Route::get("/users/login", [UserController::class, "login"])->name("login")->middleware("guest");

Route::post("/users/logout", [UserController::class, "logout"])->middleware("auth");

Route::get("/wishlists", [WishlistController::class, "index"])->middleware(['auth']);

Route::post("/wishlists/store/{item}", [WishlistController::class, "store"])->middleware(['auth']);

Route::post("/wishlists/destroy/{wishlists}", [WishlistController::class, "destroy"])->middleware(['auth']);

Route::get("/shopping-basket", [ShoppingBasketController::class, "index"])->middleware(['auth']);

Route::post("/shopping-basket/store-all", [ShoppingBasketController::class, "storeAll"])->middleware(['auth']);

Route::post("/shopping-basket/store/{item}", [ShoppingBasketController::class, "store"])->middleware(['auth']);

Route::post("/shopping-basket/update/amount", [ShoppingBasketController::class, "updateAmount"])->middleware(['auth']);

Route::post("/shopping-basket/destroy/{order}", [ShoppingBasketController::class, "destroy"])->middleware(['auth']);
