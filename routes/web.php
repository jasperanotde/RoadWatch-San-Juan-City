<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ActionSlipController;
use App\Http\Controllers\ContactUsController;

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
    if (Auth::check()) {
        return redirect()->route('home'); // Redirect to the home page
    }

    return view('auth.login');
}); // add ->middleware('verified') for production

// These routes are accessible to all users
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', 'ContactUsController@submit')->name('contact.submit');

Auth::routes([
    'verify' => true
]);

// These routes are accessible only to authenticated users
Route::group(['middleware' => ['auth']], function() { // replace to ['auth', 'verified'] for production
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('personnels', PersonnelController::class);

    // For Dashboard
    Route::get('/reports/dashboard', 'ReportController@dashboard')->name('reports.dashboard');

    Route::resource('reports', ReportController::class);
    Route::post('/reports/approve/{report}', 'ReportController@approveReport')->name('approve.report');
    Route::post('/reports/{report}/decline', [ReportController::class, 'declineReport'])->name('reports.declineReport');
    Route::post('/reports/{report}/finished', [ReportController::class, 'finishedReport'])->name('reports.finishedReport');
    Route::resource('action_slips', ActionSlipController::class);

    // Action Slip
    Route::post('/reports/{report}/submit', [ReportController::class, 'submit'])->name('reports.submit');
    Route::post('/reports/{report}/submissions', 'ReportController@updateSubmissions')->name('reports.submissions.update');
    Route::delete('/reports/{report}/submissions', 'ReportController@deleteSubmissions')->name('reports.submissions.delete');

    // Add the 'gallery' route here
    Route::get('/gallery', 'GalleryController@index')->name('gallery.index');

    Route::get('/reports/report/{category}', [ReportController::class, 'getReportsByCategory']);

    // For Notification
    Route::get('/mark-as-read', [App\Http\Controllers\ReportController::class,'markAsRead'])->name('mark-as-read');
});


