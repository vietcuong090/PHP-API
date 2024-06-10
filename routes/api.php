<?php

use App\Http\Controllers\User\IssueController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::middleware(['auth:api'])->group(function () {
        Route::prefix('user/')->name('users.')->group(function () {
            Route::post('/issues',  [IssueController::class, 'store'])->name('issues.store');
            Route::get('/issues', [IssueController::class, 'index'])->name('issues.index');
            Route::get('/issues/{id}', [IssueController::class, 'show'])->name('issues.show');
            Route::put('/issues/{id}', [IssueController::class, 'update'])->name('issues.update');
            Route::delete('/issues/{id}', [IssueController::class, 'destroy'])->name('issues.destroy');
        });

        Route::post('/logout', [AuthController::class, 'logout']);
    });
});