<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\PermissionController;

use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Master\AssetNameController;
use App\Http\Controllers\Master\AssetTypeController;
use App\Http\Controllers\Master\DerpartmentController;
use App\Http\Controllers\Master\DesignationController;
use App\Http\Controllers\Master\LocationController;

use App\Http\Controllers\Disposal\DisposalController;
use App\Http\Controllers\Issuence\IssuenceController;
use App\Http\Controllers\Transfer\TransferController;
use App\Http\Controllers\UserController;

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



Route::get('' ,[LoginController::class ,'login']);
Route::get('register',[RegisterController::class ,'register']);
Route::get('home' ,[HomeController::class ,'index']);


Route::get('stock' ,[StockController::class ,'index']);
Route::get('manage-stocks' ,[StockController::class ,'manage']);
Route::get('it-assets-stock' ,[StockController::class, 'stockStatus']);



Route::get('location' ,[LocationController::class ,'index']);
Route::get('designation' ,[DesignationController::class ,'index']);
Route::get('department' ,[DerpartmentController::class ,'index']);
Route::get('asset-name' ,[AssetNameController::class ,'index']);
Route::get('asset-type' ,[AssetTypeController::class ,'index']);



Route::get('add-role' ,[RoleController::class ,'role']);
Route::get('add-permission' ,[PermissionController::class ,'permission']);



Route::get('disposal' ,[DisposalController::class ,'index']);
Route::get('issuence' ,[IssuenceController::class ,'index']);
Route::get('transfer' ,[TransferController::class ,'index']);


Route::get('add-user' ,[UserController::class ,'user']);
Route::get('user-details' ,[UserController::class ,'userCard']);
Route::get('user-profile' ,[UserController::class ,'userProfile']);



