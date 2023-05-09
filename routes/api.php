<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;
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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('checklist', [ChecklistController::class, 'getChecklist'])->middleware('jwt.verify');
Route::post('checklist', [ChecklistController::class, 'createChecklist'])->middleware('jwt.verify');
Route::delete('checklist/{id}', [ChecklistController::class, 'deleteChecklist'])->middleware('jwt.verify');

Route::get('checklist/{id}/item', [ChecklistItemController::class, 'getChecklistItem'])->middleware('jwt.verify');
Route::post('checklist/{id}/item', [ChecklistItemController::class, 'createChecklistItem'])->middleware('jwt.verify');
Route::get('checklist/{checklist_id}/item/{item_id}', [ChecklistItemController::class, 'getChecklistItemByChecklist'])->middleware('jwt.verify');
Route::delete('checklist/{checklist_id}/item/{item_id}', [ChecklistItemController::class, 'deleteChecklistItem'])->middleware('jwt.verify');
Route::put('checklist/{checklist_id}/item/rename/{item_id}', [ChecklistItemController::class, 'updateChecklistItem'])->middleware('jwt.verify');