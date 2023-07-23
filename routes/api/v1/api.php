<?php

use App\Http\Controllers\CustomerInviteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'csv-parse'], function () {

    Route::get('getCustomerInvites', [CustomerInviteController::class, 'getCustomerInvites']);
    Route::post('saveCustomerInviteCsv', [CustomerInviteController::class, 'saveCustomerInviteCsv']);

    Route::get('testlang', function () {
        return [
            'testlang' => 'This is a test. This is CSV Parser',
        ];
    });

});
