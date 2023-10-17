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
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ChartDashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\Master\TransferReasonController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\Transfer\ReturnController;

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
    Route::get('/permission/{permission}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->name('roles.update');
    Route::put('/roles/{role}/permissions', [RolesController::class, 'updatePermissions'])->name('roles.update_permissions');
    Route::put('/roles/{role}/admin/permissions', [RolesController::class, 'updateAdminPermissions'])->name('roles.update_admin_permissions');
    Route::get('/roles/{role}/permissions', [RolesController::class, 'permissions'])->name('roles.permissions');
    Route::get('/users/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign_roles');
    Route::delete('roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
    Route::get('view-permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permission', [PermissionController::class, 'store'])->name('permission.store');
    Route::put('update-permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('getPermissionsForRole/{id}', [RolesController::class, 'fetchrole']);

    Route::delete('permissions/{id}', [PermissionController::class, 'destroy']);

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('show', [UserController::class, 'showUsers'])->name('users.show');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/get-designations/{departmentId}', [UserController::class, 'getDesignations']);
    Route::get('/get-locations/{locationId}', [UserController::class, 'getlocations']);
    Route::get('users.user-profile/{id}', [UserController::class, 'users_profile'])->name('users.user-profile');
    Route::get('users.user.profile', [UserController::class, 'usersprofile']);
    Route::put('/users/{user}/assign-roles', [UserController::class, 'updateRoles'])->name('users.update_roles');
    Route::get('home', [ChartDashboardController::class, 'index'])->name('home');
    Route::get('user_dashboard', [ChartDashboardController::class, 'userDashboard'])->name('user-dashboard');
    Route::get('stock', [StockController::class, 'index']);
    Route::get('markasread/{id}', [IssuenceController::class, 'markasread'])->name('markasread');
    Route::get('markasread-transfer/{id}', [IssuenceController::class, 'markasreadTransfer'])->name('markasread-transfer');
    Route::get('markasread-admin/{id}', [IssuenceController::class, 'markasreadAdmin'])->name('markasread-admin');
    Route::get('markasread-manager/{id}', [IssuenceController::class, 'markasreadmanager'])->name('markasread-manager');
    Route::get('markasread-transfer-manager/{id}', [IssuenceController::class, 'markasreadTransfermanager'])->name('markasread-transfer-manager');
    Route::get('approve-manager/{id}', [IssuenceController::class, 'approvemanager'])->name('approve-manager');
    Route::get('denied-manager/{id}', [IssuenceController::class, 'deniedmanager'])->name('denied-manager');
    Route::get('approve-transfer-manager/{id}', [IssuenceController::class, 'approvetransfermanager'])->name('approve-transfer-manager');
    Route::get('denied-transfer-manager/{id}', [IssuenceController::class, 'deniedtransfermanager'])->name('denied-transfer-manager');
    Route::get('markasread-controller/{id}', [IssuenceController::class, 'markasreadcontroller'])->name('markasread-controller');
    Route::post('rejection/', [IssuenceController::class, 'rejection'])->name('rejection');
    Route::get('accept-asset/{id}', [IssuenceController::class, 'AssetAccept'])->name('accept-asset');
    Route::get('transfer-accept/{id}', [IssuenceController::class, 'TransferAssetAccept'])->name('transfer-accept');
    Route::get('accept-asset-manager/{id}', [IssuenceController::class, 'AssetAcceptmanager'])->name('accept-asset-manager');
    Route::get('accept-asset-detail/{id}', [IssuenceController::class, 'AssetAcceptdetail'])->name('accept-detail-asset');
    // Transfer Reason
    Route::get('trash/transfer-reasons', [TransferReasonController::class, 'trash'])->name('trash.transfer-reasons');
    Route::get('restore/transfer-reasons/{id}', [TransferReasonController::class, 'restore'])->name('restore.transfer-reasons');
    Route::delete('/trash/transfer-reasons/{id}', [TransferReasonController::class, 'forceDelete']);
    Route::get('transfer-reasons', [TransferReasonController::class, 'index'])->name('transfer-reasons.index');
    Route::get('transfer-reasons/create', [TransferReasonController::class, 'create'])->name('transfer-reasons.create');
    Route::post('transfer-reasons', [TransferReasonController::class, 'store'])->name('transfer-reasons.store');
    Route::get('transfer-reasons/{transferReason}', [TransferReasonController::class, 'edit'])->name('transfer-reasons.edit');
    Route::put('transfer-reasons/{transferReason}', [TransferReasonController::class, 'update'])->name('transfer-reasons.update');
    Route::delete('transfer-reasons/{transferReason}', [TransferReasonController::class, 'destroy'])->name('transfer-reasons.destroy');
    Route::post('/reason-status/{reason}', [TransferReasonController::class, 'updateStatus'])->name('transfer.updateStatus');
    //Stock
    Route::post('/filter-data', [StockController::class, 'filter'])->name('filter.data');
    Route::get('/generate/number', [StockController::class, 'generateNumber']);
    Route::post('/get-brand-models/{brandId}', [StockController::class, 'getBrandModels']);
    Route::post('/get-slocation/{locationId}', [StockController::class, 'getslocation']);
    Route::post('/get-asset-type/{assettypeId}', [StockController::class, 'getasset']);
    Route::post('/get-product-type/{producttypeId}', [StockController::class, 'getproduct']);
    Route::post('/get-asset-all-details/{assetdetail}', [IssuenceController::class, 'getassetdetail']);
    Route::post('/get-change-position', [IssuenceController::class, 'getchangecard']);
    Route::get('edit-stock/{id}', [StockController::class, 'edit']);
    Route::get('all-stock', [StockController::class, 'ShowStock'])->name('all.stock');
    Route::post('store-stock', [StockController::class, 'store'])->name('store.stock');
    Route::delete('/delete-stock/{id}', [StockController::class, 'destroy'])->name('delete.stock');
    Route::post('update-stock/{id}', [StockController::class, 'update'])->name('update.stock');
    Route::put('stock-status/{stockId}', [StockController::class, 'changestockstatus'])->name('change-stock-status');
    Route::get('manage-stocks', [StockController::class, 'manage']);
    Route::get('it-assets-stock', [StockController::class, 'stockStatus']);
    Route::post('timeline/{id}', [StockController::class, 'timeline']);
    Route::get('location', [LocationController::class, 'index']);
    //Route::get('designation', [DesignationController::class, 'index']);
    Route::get('department', [DepartmentController::class, 'index']);
    Route::get('asset-name', [AssetNameController::class, 'index']);
    Route::get('asset-type', [AssetTypeController::class, 'index']);
    Route::get('add-permission', [PermissionController::class, 'permission'])->name('add.permission');
    //Disposal
    Route::get('disposal', [DisposalController::class, 'index'])->name('disposal');
    Route::post('disposal-store', [DisposalController::class, 'store'])->name('store-disposal');
    Route::get('disposal-edit/{id}', [DisposalController::class, 'edit'])->name('disposal-edit');
    Route::delete('disposal-delete/{id}', [DisposalController::class, 'destroy'])->name('disposal-delete');
    Route::put('disposal-update/{id}', [DisposalController::class, 'update'])->name('disposal-update');

    //Searct Employee id
    Route::get('server_script', [IssuenceController::class, 'index']);
    Route::get('server_asset_script', [TransferController::class, 'index']);
    Route::get('transfer', [TransferController::class, 'index']);
    Route::post('transfer/store', [TransferController::class, 'store'])->name('transfer-store');
    Route::get('transfer/all', [TransferController::class, 'showAll'])->name('all-transfers');
    Route::get('search-master', [SearchController::class, 'searchAll'])->name('search-master');
    Route::get('search', [SearchController::class, 'search'])->name('search');
    Route::get('/user/{id}/timeline', [SearchController::class, 'userTimeline'])->name('user-timeline');
    Route::get('/stock/{id}/timeline', [SearchController::class, 'stockTimeline'])->name('stock-timeline');
    Route::get('add-user', [UserController::class, 'user']);
    Route::get('user-details', [UserController::class, 'userCard']);

    //Asset Return
    Route::get('/return', [ReturnController::class, 'index'])->name('return');
    Route::post('/asset-return', [ReturnController::class, 'submit'])->name('submit');
    //Assets
    Route::get('non-it-asset', [AssetController::class, 'nonitasset'])->name('non.it.assets');
    Route::get('asset-components', [AssetController::class, 'assetscomponent'])->name('assets.components');
    Route::get('asset-software', [AssetController::class, 'assetsoftware'])->name('assets.software');

    //asset type
    Route::get('trsah/asset-type/{id}', [AssetTypeController::class, 'restore'])->name('trsah.asset-type');
    Route::get('/trash/asset_type', [AssetTypeController::class, 'trash'])->name('trash.asset_type');
    Route::delete('/trash/asset/type/{id}', [AssetTypeController::class, 'forceDelete']);
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
    Route::get('location/trash', [LocationController::class, 'trash'])->name('location.trash');
    Route::get('location/restore/{id}', [LocationController::class, 'restore'])->name('location.restore');
    Route::delete('/trash/location/{id}', [LocationController::class, 'forceDelete']);
    Route::get('location-show', [LocationController::class, 'show'])->name('location-show');
    Route::get('location-index', [LocationController::class, 'index'])->name('location-index');
    Route::get('location-create', [LocationController::class, 'create'])->name('location-create');
    Route::post('location-store', [LocationController::class, 'store'])->name('location-store');
    Route::put('location-update/{location}', [LocationController::class, 'update'])->name('location-update');
    Route::put('location-status/{locationId}', [LocationController::class, 'locationStatus'])->name('locationf-status');
    Route::delete('location-destroy/{location}', [LocationController::class, 'destroy'])->name('location-destroy');
    Route::get('location-edit/{id}', [LocationController::class, 'edit'])->name('location-edit');
    Route::post('/check-location-duplicate', [LocationController::class, 'checkLocationDuplicate'])->name('check-location-duplicate');
    //Sub-Location
    Route::get('trash/sub-location', [SubLocationController::class, 'trash'])->name('trash.sub-location');
    Route::get('restore/sub-location/{id}', [SubLocationController::class, 'restore'])->name('restore.sub-location');
    Route::delete('/sub-location-permanently-delete/{id}', [SubLocationController::class, 'forceDelete']);
    Route::get('sublocation-show', [SubLocationController::class, 'show'])->name('sublocation-show');
    Route::get('sublocation-index', [SubLocationController::class, 'index'])->name('sublocation-index');
    Route::get('sublocation-create', [SubLocationController::class, 'create'])->name('sublocation-create');
    Route::post('sublocation-store', [SubLocationController::class, 'store'])->name('sublocation-store');
    Route::get('sublocation-edit/{id}', [SubLocationController::class, 'edit'])->name('sublocation-edit');
    Route::post('location-update-status/{id}', [SubLocationController::class, 'updateStatus'])->name('location-update-status');
    Route::put('sublocation-update/{sublocation}', [SubLocationController::class, 'update'])->name('sublocation-update');
    Route::delete('sublocation-destroy/{sublocation}', [SubLocationController::class, 'destroy'])->name('sublocation-destroy');
    Route::put('sublocation-status/{sublocationId}', [SubLocationController::class, 'updateStatus'])->name('sublocation-status');
    //employee_issue
    Route::get('employee/issue', [IssuenceController::class, 'employee_issue'])->name('employee.issue');
    Route::get('all/issue', [IssuenceController::class, 'employee_all_issue'])->name('employee.all.issue');
    Route::get('employee/all/transfer', [IssuenceController::class, 'all_transfer'])->name('employee.all.transfer');
    //designationFget
    Route::get('designations/trash', [DesignationController::class, 'trash'])->name('designation.trash');
    Route::get('designations/restore/{id}', [DesignationController::class, 'restore'])->name('designations.restore');
    Route::delete('/designations-permanently-delete/{id}', [DesignationController::class, 'forceDelete']);
    Route::get('designations', [DesignationController::class, 'index'])->name('designations.index');
    Route::post('designations', [DesignationController::class, 'store'])->name('designations.store');
    Route::get('/designations/create', [DesignationController::class, 'create'])->name('designations.create');
    Route::get('designations/{id}/edit', [DesignationController::class, 'edit'])->name('designations.edit');
    Route::put('designations/{id}', [DesignationController::class, 'update'])->name('designations.update');
    Route::delete('designations/{id}', [DesignationController::class, 'destroy'])->name('designations.destroy');
    //assets
    Route::get('assets/trash', [AssetController::class, 'trash'])->name('assets.trash');
    Route::get('assets/restore/{id}', [AssetController::class, 'restore'])->name('assets.restore');
    Route::delete('/assets-permanently-delete/{id}', [AssetController::class, 'forceDelete']);
    Route::post('get-asset-details/{assetTypeId}', [AssetController::class, 'getassetdetails']);
    Route::get('assets', [AssetController::class, 'index'])->name('assets.index')->middleware('permission:manage_asset');
    Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create')->middleware('permission:create_asset');
    Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
    Route::get('assets/{id}/edit', [AssetController::class, 'edit'])->name('assets.edit')->middleware('permission:edit_asset');
    Route::put('assets/{id}', [AssetController::class, 'update'])->name('assets.update');
    Route::delete('assets/{id}', [AssetController::class, 'destroy'])->name('assets.destroy')->middleware('permission:delete_asset');
    // routes/web.php.
    //Status
    Route::get('trash/status', [StatusController::class, 'trash'])->name('trash.status');
    Route::get('restore/status/{id}', [StatusController::class, 'restore'])->name('restore.status');
    Route::delete('/status-permanently-delete/{id}', [StatusController::class, 'forceDelete']);
    Route::get('add-status', [StatusController::class, 'status'])->name('change-status');
    Route::post('save-status', [StatusController::class, 'save'])->name('status-save');
    Route::get('status-edit/{id}', [StatusController::class, 'edit'])->name('status-edit');
    Route::put('update-status/{id}', [StatusController::class, 'update'])->name('update-status');
    Route::delete('status-delete/{id}', [StatusController::class, 'destroy'])->name('status-delete');
    //Brand
    Route::get('trash/brand', [BrandController::class, 'trash'])->name('trash.brand');
    Route::get('restore/brand/{id}', [BrandController::class, 'restore'])->name('restore.brand');
    Route::delete('/brand-permanently-delete/{id}', [BrandController::class, 'forceDelete']);
    Route::get('/brands/create', [BrandController::class, 'create'])->name('create-brand');
    Route::post('/brands', [BrandController::class, 'store']);
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/brands/{id}/edit', [BrandController::class, 'edit']);
    Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy']);
    Route::post('/brands/{brand}', [BrandController::class, 'updateStatus'])->name('brands.updateStatus');
    Route::post('/brands-model/{brand}', [BrandModelController::class, 'updateStatus'])->name('brands.model.updateStatus');
    Route::resource('brand-model', BrandmodelController::class);
    Route::get('trash/model', [BrandmodelController::class, 'trash'])->name('trash.model');
    Route::get('restore/model/{id}', [BrandmodelController::class, 'restore'])->name('restore.model');
    Route::delete('/model-permanently-delete/{id}', [BrandmodelController::class, 'forceDelete']);

    //Reports
    Route::get('search/report',[ReportController::class,'search_report'])->name('search-reports');
    Route::get('all-reports', [ReportController::class, 'allreport'])->name('all-reports');
    Route::get('asset-activity-report', [ReportController::class, 'activity_report'])->name('activity-reports');
    Route::get('assets-report-status', [ReportController::class, 'report_status'])->name('report-status');
    Route::get('component-reports', [ReportController::class, 'component_reports'])->name('component-activity-reports');
    Route::get('maintenance-report', [ReportController::class, 'maintenance'])->name('maintenance-report');
    Route::get('reports-types', [ReportController::class, 'report_type'])->name('report-type');
    Route::get('reports-suppliers', [ReportController::class, 'report_supplier'])->name('report-supplier');
    Route::get('reports-locations', [ReportController::class, 'report_location'])->name('report-location');

    //PDF and CSV
    Route::get('/load-disposal-pdf', [DisposalController::class, 'disposal_pdf'])->name('load-disposal-pdf');
    Route::get('/load-disposal', [DisposalController::class, 'load_disposal'])->name('load-disposal-report');
    Route::get('/maintenance-reports', [MaintenanceController::class, 'maintenance_reports'])->name('maintenance-reports');
    Route::get('/maintenance-repo', [MaintenanceController::class, 'maintenance_rep'])->name('maintenance-repo');
    Route::post('/getPDF', [ReportController::class, 'generatePDF']);
    Route::get('/gettimelinePDF/{id}', [ReportController::class, 'PDFtimeline']);
    Route::get('/component', [ReportController::class, 'pdfcomponent']);
    Route::get('/maintenance', [ReportController::class, 'pdfmaintenance']);
    Route::get('/locations', [ReportController::class, 'pdflocation']);
    Route::get('/supplier', [ReportController::class, 'pdfsupplier']);
    Route::get('/type', [ReportController::class, 'pdftype']);
    Route::get('/status', [ReportController::class, 'pdfstatus']);
    Route::get('/export-data', [ReportController::class, 'exportData'])->name('exports.data');
    //Print
    Route::post('/getPrint', [ReportController::class, 'getPrint']);
    Route::get('/getComponent', [ReportController::class, 'getComponent']);
    Route::get('/getMaintenance', [ReportController::class, 'getMaintenance']);
    Route::get('/getSupplier', [ReportController::class, 'getSupplier']);
    Route::get('/getLocation', [ReportController::class, 'getLocation']);
    Route::get('/getType', [ReportController::class, 'getType']);
    Route::get('/getStatus', [ReportController::class, 'getStatus']);
    Route::post('/import-csv', [AssetTypeController::class, 'import_csv'])->name('import.csv');
    Route::post('import-department', [DepartmentController::class, 'import'])->name('import.department');
    //Maintenances
    Route::get('maintenance', [MaintenanceController::class, 'index']);
    Route::get('asset-maintenances', [MaintenanceController::class, 'maintenances'])->name('assets-maintenances');
    Route::post('asset-maintenance', [MaintenanceController::class, 'maintenance_save'])->name('maintenance-save');
    Route::get('maintainans-edit/{id}', [MaintenanceController::class, 'edit'])->name('maintenance-edit');
    Route::delete('maintainans-delete/{id}', [MaintenanceController::class, 'destroy'])->name('maintainans-delete');
    Route::put('maintainans-update/{id}', [MaintenanceController::class, 'update'])->name('maintainans-Update');
    Route::get('maintenance/edit/{id}', [MaintenanceController::class, 'maintenance_edit'])->name('maintenance.edit');
    Route::post('/maintainans/update/{productId}', [MaintenanceController::class, 'statusupdate'])->name('maintenance.update.status');

    //Receive Maintenance
    Route::get('receive-maintenance', [MaintenanceController::class, 'receive'])->name('receive-maintenance');
    Route::get('maintenance-print/{id}', [MaintenanceController::class, 'download'])->name('maintenance-print');
    Route::post('/get-suppliers/{id}', [MaintenanceController::class, 'getSuppliers'])->name('get-suppliers');
    Route::get('/get-statuses', [MaintenanceController::class, 'getStatuses'])->name('get-statuses');

    //Attribute
    Route::get('trash/attributes', [AttributeController::class, 'trash'])->name('trash.attributes');
    Route::get('restore/attributes/{id}', [AttributeController::class, 'restore'])->name('restore.attributes');
    Route::delete('/attributes-permanently-delete/{id}', [AttributeController::class, 'forceDelete']);
    Route::get('attributes', [AttributeController::class, 'home'])->name('attributes-index');
    Route::post('attribute-store', [AttributeController::class, 'store'])->name('attribute-store');
    Route::get('/attributes/{id}/edit', [AttributeController::class, 'edit']);
    Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attribute-update');
    Route::delete('/attributes/{id}', [AttributeController::class, 'destroy']);
    Route::post('/attributes/{attributes}', [AttributeController::class, 'updateStatus'])->name('attribute-updateStatus');
    // Route::post('/getAttributes/{assettypeId}', [AttributeController::class, 'getAttribute'])->name('getAttribute');
    //Department
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('auth.create-department');
    Route::get('/departments/{id}/restore', [DepartmentController::class, 'restore'])->name('restore.department');
    Route::get('/trsah-department', [DepartmentController::class, 'trash'])->name('trash.department');
    Route::delete('/department-permanently-delete/{id}', [DepartmentController::class, 'forceDelete']);
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments-index');
    Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->middleware('permission:delete_department');
    Route::post('/departments/{department}', [DepartmentController::class, 'updateStatus'])->name('departments.updateStatus');
    //Supplier
    Route::get('trash/suppliers', [SupplierController::class, 'trash'])->name('trash.suppliers');
    Route::get('restore/suppliers/{id}', [SupplierController::class, 'restore'])->name('restore.suppliers');
    Route::delete('/suppliers-permanently-delete/{id}', [SupplierController::class, 'forceDelete']);
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::post('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');


    Route::get('/application-setting', [SettingController::class, 'index'])->name('settings.application');
    Route::put('/application-settings', [SettingController::class, 'createOrUpdate'])->name('settings.application.storeOrUpdate');

    Route::get('/user-setting', [ChangePasswordController::class, 'index'])->name('settings.user');
    Route::post('/update-password', [ChangePasswordController::class, 'changePassword'])->name('update_password');
    Route::post('update-profile-photo', [ChangePasswordController::class, 'updateProfilePhoto'])->name('profile.photo.update');

    Route::get('/send-email', [SendEmailController::class, 'index'])->name('emails.send');
    Route::put('/update-email', [SendEmailController::class, 'update'])->name('emails.update');

    Route::get('/profile-photo', [ChangePasswordController::class, 'profilePhoto'])->name('profile_photo');
    Route::put('/update-profile-photo', [ChangePasswordController::class, 'updateProfilePhoto'])->name('update_profile_photo');
    Route::get('/cover-photo', [ChangePasswordController::class, 'coverPhoto'])->name('cover_photo');
    Route::put('/update-cover-photo', [ChangePasswordController::class, 'updateCoverPhoto'])->name('update_cover_photo');


    Route::get('/forget-password', [ForgotPasswordController::class, 'forgetPassword'])->name('forget.password');
    Route::post('/forget-password', [ForgotPasswordController::class, 'forgetPasswordPost'])->name('forget.password.post');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPasswordPost'])->name('reset.password.post');

    Route::group(['middleware' => ['permission.checkDepartment']], function () {
    });

    Route::get('/issuences', [IssuenceController::class, 'index'])->name('issuences.index');
    Route::post('/issuence/store', [IssuenceController::class, 'store'])->name('issuence.store');
    Route::get('/issuences/all', [IssuenceController::class, 'showAll'])->name('issuances.all');
    Route::get('/fetch-Card-info', [IssuenceController::class, 'CardInfo'])->name('fetch-Card-info');
    Route::post('update/stock/status', [IssuenceController::class, 'updatestockstatus'])->name('update.stock.status');
});
