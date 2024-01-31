<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MondayAuthController;
use App\Http\Controllers\testController;

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

Route::get('/', function () {
    return view('welcome');
});

# receive token
Route::get('/monday/auth', [MondayAuthController::class, 'redirectToMonday']);
Route::get('/monday/callback', [MondayAuthController::class, 'handleMondayCallback']);

# boards
Route::post('/retrieve-board', [testController::class, 'retreiveBoards']);
Route::post('/create-board', [testController::class, 'createBoard']);
Route::post('/duplicate-board', [testController::class, 'duplicateBoard']);
Route::post('/update-board', [testController::class, 'updateBoard']);
Route::post('/delete-board', [testController::class, 'deleteBoard']);
