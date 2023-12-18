<?php

use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AssetUnitController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Assignments\Ticket\Approval;
use App\Livewire\Assignments\Ticket\Approved;
use App\Livewire\AssetManagement\Unit\Index as UnitIndex;
use App\Livewire\Assignments\Ticket\Index as TicketIndex;
use App\Livewire\AssetManagement\Asset\Index as AssetIndex;
use App\Livewire\AssetManagement\Category\Index as CategoryIndex;
use App\Livewire\Assignments\Assignment\Index as AssignmentIndex;

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
    return view('auth.login');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    // Route for Admin
    Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {

        //DASHBOARD
        // Route::controller(Dashboard::class)->group(function () {
        //     Route::get('/', 'index')->name('dashboard');
        // });

        Route::get('/', Dashboard::class)->name('dashboard');

        Route::prefix('/asset-management')->name('assetmanagement.')->group(function () {

            Route::prefix('/assets')->name('assets.')->group(function () {
                Route::get('/', AssetIndex::class)->name('index');

            });

            Route::prefix('/units')->name('units.')->group(function () {
                Route::get('/{id}', UnitIndex::class)->name('index');

            });

            Route::prefix('/categories')->name('categories.')->group(function () {
                Route::get('/', CategoryIndex::class)->name('index');
            });


            // Route::prefix('/assets')->controller(AssetController::class)->name('assets.')->group(function () {

            //     // Route::resource('/', AssetController::class);
            //     Route::post('/getcategorieslist', 'getCategoriesList')->name('getcategorieslist');
            //     Route::post('/unit/{id}', 'unitList')->name('unitlist');
            //     Route::get('/deleteassetconfirm/{id}', 'deleteAssetConfirmation')->name('deleteassetconfirmation');
            //     Route::delete('/deleteasset/{id}', 'deleteAsset')->name('deleteasset');
            // });

            // Route::prefix('/categories')->controller(CategoryController::class)->name('categories.')->group(function () {
            //     Route::resource('/', CategoryController::class);
            //     Route::get('/deletecategoryconfirm/{id}', 'deleteCategoryConfirmation')->name('deletecategoryconfirmation');
            //     Route::delete('/deletecategory/{id}', 'deleteCategory')->name('deletecategory');
            // });

            Route::resource('assets.units', AssetUnitController::class);

        });


        Route::prefix('/assignment')->name('assignment.')->group(function () {

            Route::prefix('/tickets')->name('ticket.')->group(function () {

                Route::get('/', TicketIndex::class)->name('index');

                Route::get('/approved/{id}', Approved::class)->name('approved');
                // Route::get('/approved/{id}', Approval::class)->name('approved');


                // Route::get('/', 'index')->name('index');
                // Route::get('/detail/{id}', 'ticketDetail')->name('ticketdetail');
                // Route::post('/assetlistassigment/{id}', 'assetListAssigment')->name('assetlistassigment');
                // Route::post('/getunitlist/{id}', 'getUnitList')->name('getunitlist');
                // Route::post('/approvalstore', 'approvalStore')->name('approvalstore');
            });

            Route::prefix('/assignments')->name('assignments.')->group(function () {

                Route::get('/', AssignmentIndex::class)->name('index');


                // Route::get('/', 'index')->name('index');
                // Route::get('/detail/{id}', 'ticketDetail')->name('ticketdetail');
                Route::post('/assetlistassigment/{id}', [TicketController::class, 'assetListAssignment'])->name('assetlistassignment');

                Route::post('/getunitlist/{asset_id}/{ticket_id}', [TicketController::class, 'getUnitList'])->name('getunitlist');

                // Route::post('/getunitlist/{id}', 'getUnitList')->name('getunitlist');
                // Route::post('/approvalstore', 'approvalStore')->name('approvalstore');
            });

            // Route::prefix('/assignments')->controller(AssignmentListController::class)->name('assignments.')->group(function () {
            //     Route::get('/', 'index')->name('index');
            //     Route::get('/detail/{id}', 'show')->name('show');
            // });

        });


    });


    // Route for User
    // Route::prefix('user')->name('user.')->group(function () {
    //     //DASHBOARD
    //     Route::controller(DashboardController::class)->group(function () {
    //         Route::get('/', 'index')->name('dashboard');
    //     });
    // });
});
