<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ActionSlipController;

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

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::resource('reports', 'ReportController');

/* This is a new route for roles and permission
    For testing atm */
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('reports', ReportController::class);
    Route::post('/reports/approve/{report}', 'ReportController@approveReport')->name('approve.report');
    Route::post('/reports/{report}/decline', [ReportController::class, 'declineReport'])->name('reports.declineReport');
    Route::post('/reports/{report}/finished', [ReportController::class, 'finishedReport'])->name('reports.finishedReport');
    Route::resource('action_slips', ActionSlipController::class);
    Route::post('/reports/{report}/submit', [ReportController::class, 'submit'])->name('reports.submit');
    Route::delete('/reports/{report}/submissions', 'ReportController@deleteSubmissions')->name('reports.submissions.delete');

    // Add the 'gallery' route here
    Route::get('/gallery', 'GalleryController@index')->name('gallery.index');

    Route::get('/reports/report/{category}', [ReportController::class, 'getReportsByCategory']);

});



