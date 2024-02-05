<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MondayAuthController;
use App\Http\Controllers\boardController;
use App\Http\Controllers\webhookController;

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
Route::get('/monday/oauth/callback', [MondayAuthController::class, 'handleMondayCallback']);

# boards
Route::post('/retrieve-board', [boardController::class, 'retreiveBoards']);
Route::post('/create-board', [boardController::class, 'createBoard']);
Route::post('/duplicate-board', [boardController::class, 'duplicateBoard']);
Route::post('/update-board', [boardController::class, 'updateBoard']);
Route::post('/delete-board', [boardController::class, 'deleteBoard']);

# webhook
Route::post('/yanranintern/webhook', [webhookController::class, 'handleWebhookChallenge']);
