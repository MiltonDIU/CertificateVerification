<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\FacultyApiController;
use App\Http\Controllers\Api\V1\Admin\ConvocationsApiController;
use App\Http\Controllers\Api\V1\Admin\ProgramsApiController;
use App\Http\Controllers\Api\V1\Admin\StudentApiController;
use App\Http\Controllers\Api\V1\Admin\AuthUserApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/auth/register', [AuthUserApiController::class, 'createUser']);
Route::post('/auth/login', [AuthUserApiController::class, 'loginUser']);

Route::apiResource('faculties',  FacultyApiController::class);

Route::apiResource('students', StudentApiController::class);
Route::get('student-result/{hash_code}',[StudentApiController::class,'studentResult'])->name('studentResult');
Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {
    // Faculty
   // Route::apiResource('faculties',  FacultyApiController::class);

    // Convocations
    Route::post('convocations/media', [ConvocationsApiController::class,'storeMedia'])->name('convocations.storeMedia');
    Route::apiResource('convocations', ConvocationsApiController::class);

    // Programs
    Route::apiResource('programs', ProgramsApiController::class);

    // Student
    //Route::apiResource('students', StudentApiController::class);
});
