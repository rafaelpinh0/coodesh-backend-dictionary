<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// [GET] /
Route::get('/', [ApiController::class, 'index']);

Route::controller(UserController::class)->group(function () {

    // [POST] /auth/signup
    Route::post('/signup', 'signup');

    // [POST] /auth/signin
    Route::post('/signin', 'signin');
});

Route::middleware([CacheResponse::class, AuthenticateToken::class])->group(function () {

    Route::controller(ApiController::class)->group(function () {

        Route::prefix('/entries/en')->group(function () {

            // [GET] /entries/en
            Route::get('/', 'all');

            Route::prefix('/{word}')->group(function () {

                // [GET] /entries/en/:word
                Route::get('/', 'search');

                // [POST] /entries/en/:word/favorite
                Route::post('/favorite', 'favorite');

                // [DELETE] /entries/en/:word/unfavorite
                Route::delete('/unfavorite', 'unfavorite');
            });
        });
    });

    Route::controller(UserController::class)->group(function () {

        Route::prefix('/user/me')->group(function () {

            // [GET] /user/me
            Route::get('/', 'show');

            // [GET] /user/me/history
            Route::get('/history', 'history');

            // [GET] /user/me/favorites
            Route::get('/favorites', 'favorites');
        });
    });
});
