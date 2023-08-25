<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Master\AssetNameController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrandmodelController;
use App\Http\Controllers\Disposal\DisposalController;
use App\Http\Controllers\Issuence\IssuenceController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Transfer\TransferController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SubLocationController;
use App\Http\Controllers\AttributeController;

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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('/');
Route::post('check-login', [LoginController::class, 'login'])->name('check-login');
Route::get('register', [RegisterController::class, 'register']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
// Routes with authentication
Route::group(['middleware' => 'auth'], function () {

    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->name('roles.update');
    Route::get('/roles/{role}/permissions', [RolesController::class, 'permissions'])->name('roles.permissions');
    Route::put('/roles/{role}/permissions', [RolesController::class, 'updatePermissions'])->name('roles.update_permissions');
    Route::get('/users/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign_roles');
    Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');
    Route::get('view-permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::put('update-permissions', [PermissionController::class, 'update'])->name('permissions.update');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('show', [UserController::class, 'showUsers'])->name('users.show');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/get-designations/{departmentId}', [UserController::class, 'getDesignations']);
    Route::get('users.user-profile/{id}', [UserController::class, 'users_profile'])->name('users.user-profile');
    Route::get('users.user.profile', [UserController::class, 'usersprofile']);

    Route::put('/users/{user}/assign-roles', [UserController::class, 'updateRoles'])->name('users.update_roles');

    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('stock', [StockController::class, 'index']);

    Route::post('/get-brand-models/{brandId}', [StockController::class, 'getBrandModels']);
    Route::post('/get-slocation/{locationId}', [StockController::class, 'getslocation']);
    Route::post('/get-asset-type/{assettypeId}', [StockController::class, 'getasset']);
    Route::post('/get-asset-all-details/{assetdetail}', [IssuenceController::class, 'getassetdetail']);


    Route::get('edit-stock/{id}', [StockController::class, 'edit']);
    Route::get('all-stock', [StockController::class, 'ShowStock'])->name('all.stock');
    Route::post('store-stock', [StockController::class, 'store'])->name('store.stock');
    Route::post('update-stock/{id}', [StockController::class, 'update'])->name('update.stock');
    Route::put('stock-status/{stockId}', [StockController::class, 'changestockstatus'])->name('change-stock-status');
    Route::get('manage-stocks', [StockController::class, 'manage']);
    Route::get('it-assets-stock', [StockController::class, 'stockStatus']);
    Route::get('timeline', [StockController::class, 'timeline']);
    Route::get('location', [LocationController::class, 'index']);
    //Route::get('designation', [DesignationController::class, 'index']);
    Route::get('department', [DepartmentController::class, 'index']);
    Route::get('asset-name', [AssetNameController::class, 'index']);
    Route::get('asset-type', [AssetTypeController::class, 'index']);
    Route::get('add-permission', [PermissionController::class, 'permission']);
    Route::get('disposal', [DisposalController::class, 'index']);
    //Searct Employee id
    Route::get('server_script', [IssuenceController::class, 'index']);
    Route::get('transfer', [TransferController::class, 'index']);
    Route::get('add-user', [UserController::class, 'user']);
    Route::get('user-details', [UserController::class, 'userCard']);
    //Assets
    Route::get('non-it-assets-timeline', [AssetController::class, 'views'])->name('non-it-assets-timeline');
    Route::get('assets-component-timeline', [AssetController::class, 'compotimeline'])->name('assets-component-timeline');
    Route::get('assets-software-timeline', [AssetController::class, 'softwaretimeline'])->name('assets-software-timeline');
    Route::get('non-it-asset', [AssetController::class, 'nonitasset'])->name('non.it.assets');
    Route::get('asset-components', [AssetController::class, 'assetscomponent'])->name('assets.components');
    Route::get('asset-software', [AssetController::class, 'assetsoftware'])->name('assets.software');

    //asset type
    Route::get('assets-type-show', [AssetTypeController::class, 'show'])->name('assets-type-show');
    Route::get('assets-type-index', [AssetTypeController::class, 'index'])->name('assets-type-index');
    Route::get('assets-type-create', [AssetTypeController::class, 'create'])->name('assets-type-create');
    Route::post('assets-type-store', [AssetTypeController::class, 'store'])->name('assets-type-store');
    Route::put('assets-type-update/{asset}', [AssetTypeController::class, 'update'])->name('assets-type-update');
    Route::put('assets-type-status/{assetId}', [AssetTypeController::class, 'assetTypeStatus'])->name('assets-type-status');
    Route::put('assets-status/{assetId}', [AssetController::class, 'assetStatus'])->name('assets-status');
    Route::delete('assets-type-destroy/{asset}', [AssetTypeController::class, 'destroy'])->name('assets-type-destroy');
    Route::get('assets-type-edit/{id}', [AssetTypeController::class, 'edit'])->name('assets-type-edit');
    // Route::resource('assets', AssetTypeController::class);
    //locations
    Route::get('location-show', [LocationController::class, 'show'])->name('location-show');
    Route::get('location-index', [LocationController::class, 'index'])->name('location-index');
    Route::get('location-create', [LocationController::class, 'create'])->name('location-create');
    Route::post('location-store', [LocationController::class, 'store'])->name('location-store');
    Route::put('location-update/{location}', [LocationController::class, 'update'])->name('location-update');
    Route::put('location-status/{locationId}', [LocationController::class, 'locationStatus'])->name('location-status');
    Route::delete('location-destroy/{location}', [LocationController::class, 'destroy'])->name('location-destroy');
    Route::get('location-edit/{id}', [LocationController::class, 'edit'])->name('location-edit');
    //Sub-Location
    Route::get('sublocation-show', [SubLocationController::class, 'show'])->name('sublocation-show');
    Route::get('sublocation-index', [SubLocationController::class, 'index'])->name('sublocation-index');
    Route::get('sublocation-create', [SubLocationController::class, 'create'])->name('sublocation-create');
    Route::post('sublocation-store', [SubLocationController::class, 'store'])->name('sublocation-store');
    Route::get('sublocation-edit/{id}', [SubLocationController::class, 'edit'])->name('sublocation-edit');
    Route::post('location-update-status/{id}', [SubLocationController::class, 'updateStatus'])->name('location-update-status');
    Route::put('sublocation-update/{sublocation}', [SubLocationController::class, 'update'])->name('sublocation-update');
    Route::delete('sublocation-destroy/{sublocation}', [SubLocationController::class, 'destroy'])->name('sublocation-destroy');
    Route::put('sublocation-status/{sublocationId}', [SubLocationController::class, 'updateStatus'])->name('sublocation-status');
    //designationFget
    Route::get('designations', [DesignationController::class, 'index'])->name('designations.index');
    Route::post('designations', [DesignationController::class, 'store'])->name('designations.store');
    Route::get('/designations/create', [DesignationController::class, 'create'])->name('designations.create');
    Route::get('designations/{id}/edit', [DesignationController::class, 'edit'])->name('designations.edit');
    Route::put('designations/{id}', [DesignationController::class, 'update'])->name('designations.update');
    Route::delete('designations/{id}', [DesignationController::class, 'destroy'])->name('designations.destroy');
    //assets
    Route::post('get-asset-details/{assetTypeId}', [AssetController::class, 'getassetdetails']);
    Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create');
    Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
    Route::get('assets/{id}/edit', [AssetController::class, 'edit'])->name('assets.edit');
    Route::put('assets/{id}', [AssetController::class, 'update'])->name('assets.update');
    Route::delete('assets/{id}', [AssetController::class, 'destroy'])->name('assets.destroy');
    // routes/web.php
    //Brand
    Route::get('/brands/create', [BrandController::class, 'create'])->name('create-brand');
    Route::post('/brands', [BrandController::class, 'store']);
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/brands/{id}/edit', [BrandController::class, 'edit']);
    Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy']);
    Route::post('/brands/{brand}', [BrandController::class, 'updateStatus'])->name('brands.updateStatus');
    Route::post('/brands-model/{brand}', [BrandModelController::class, 'updateStatus'])->name('brands.model.updateStatus');
    Route::resource('brand-model', BrandmodelController::class);
    //Attribute
    Route::get('attributes', [AttributeController::class, 'home'])->name('attributes-index');
    Route::post('attribute-store', [AttributeController::class, 'store'])->name('attribute-store');
    Route::get('/attributes/{id}/edit', [AttributeController::class, 'edit']);
    Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attribute-update');
    Route::delete('/attributes/{id}', [AttributeController::class, 'destroy']);
    Route::post('/attributes/{attributes}', [AttributeController::class, 'updateStatus'])->name('attribute-updateStatus');

    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('auth.create-department');
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);
    Route::post('/departments/{department}', [DepartmentController::class, 'updateStatus'])->name('departments.updateStatus');

    Route::group(['middleware' => ['permission.checkDepartment']], function () {
    });

    Route::get('/issuences', [IssuenceController::class, 'index'])->name('issuences.index');
});
