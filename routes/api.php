<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DeliveryController;
use App\Models\Message;

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

Route::prefix('delivery')->middleware('verify.delivery')->group(function () {
    Route::post('verify', [DeliveryController::class, 'verify']);
    Route::get('stats/{filters?}', [DeliveryController::class, 'stats']);
    Route::post('message/store/{key}', [DeliveryController::class, 'storeMessage']);
    Route::get('messages/{page}/{limit}/{search?}', [DeliveryController::class, 'messages']);
    Route::delete('message/{message_id}', [DeliveryController::class, 'deleteMessage']);
});

Route::get('cron/{password}', [AppController::class, 'cron']);

Route::get('domains/{key}', [APIController::class, 'domains']);
Route::get('email/{email}/{key}', [APIController::class, 'email']);
Route::get('messages/{email}/{key}', [APIController::class, 'messages']);
Route::get('message/{message_id}/{key}', [APIController::class, 'message']);
Route::delete('message/{message_id}/{key}', [APIController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
