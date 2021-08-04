<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RaysRequestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MedicalTestRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('switch-language/{lang}', 'HomeController@switchLang')->name('switchLang');
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]], function()
{
    Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
    Route::middleware('auth')->group(function ()
    {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        // Patient related routes.
        Route::get('patient/blocked', 'PatientController@blockedPatients')->name('patient.blockedPatients');
        Route::get('patient/emergency', 'PatientController@emergencyPatients')->name('patient.emergencyPatients');
        Route::get('patient/search', 'PatientController@search')->name('patient.search');
        Route::get('patient/{patient}/diagnoses', 'PatientController@diagnoses')->name('patient.diagnoses');
        Route::patch('patient/{patient}/change-status', 'PatientController@changeStatus')->middleware('doctor')->name('patient.changeStatus');
        Route::patch('patient/{patient}/addDiagnose', 'PatientController@addDiagnose')->middleware('doctor')->name('patient.addDiagnose');
        Route::post('patient/rays-request/{patient}', 'PatientController@raysRequest')->middleware('doctor')->name('patient.raysRequest');
        Route::post('patient/request/medical-test/{patient}', 'PatientController@medicalTestRequest')->middleware('doctor')->name('patient.medicalTestRequest');
        Route::resource('patient', 'PatientController');

        // Reservations
        Route::get('patient/{patient}/reservation', [ReservationController::class, 'showForm'])->name('reservation.showForm');
        Route::post('reservation/doctor-times', [ReservationController::class, 'getDoctorTimes'])->name('reservation.getDoctorTimes');
        Route::post('reservation/store', [ReservationController::class, 'store'])->name('reservation.store');
        Route::post('reservation/change-status', [ReservationController::class, 'changeStatus'])->name('reservation.changeStatus');
        Route::delete('reservation/{reservation}/destroy', [ReservationController::class, 'destroy'])->name('reservation.destroy');

        // User related routes.
        Route::get('user/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::patch('user/updateData', [UserController::class, 'updateData'])->name('user.updateData');
        Route::patch('user/updatePhoto', [UserController::class, 'updatePhoto'])->name('user.updatePhoto');
        Route::patch('user/updatePassword', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    });
    # Doctor related routes.
    Route::group(['middleware' => ['auth', 'doctor']], function () {
        Route::patch('doctor/update-work-times', [DoctorController::class, 'updateWorkTimes'])->name('doctor.updateWorkTimes');
        Route::get('doctor/waiting-list', [DoctorController::class, 'waitingList'])->name('doctor.waitingList');
        Route::get('doctor/rays-requests', [DoctorController::class, 'raysRequests'])->name('doctor.raysRequests');
        Route::delete('doctor/rays-requests/{rayRequest}', [DoctorController::class, 'destroyRaysRequest'])->name('doctor.raysRequests.destroy');
        Route::get('doctor/test-request', [DoctorController::class, 'testsRequests'])->name('doctor.testsRequests');
        Route::delete('doctor/test-request/{testRequest}', [DoctorController::class, 'destroyTestRequest'])->name('doctor.testRequest.destroy');
    });
    # Technician related routes.
    Route::group(['middleware' => ['auth', 'technician']], function () {
        Route::get('rays-request', [RaysRequestController::class, 'index'])->name('raysRequest.index');
        Route::get('rays-request/{rayRequest}/add-result', [RaysRequestController::class, 'addResult'])->name('raysRequest.addResult');
        Route::Patch('rays-request/{rayRequest}/store-result', [RaysRequestController::class, 'storeResult'])->name('raysRequest.storeResult');
    });
    # Test Responsible related routes.
    Route::group(['middleware' => ['auth', 'testResponsible']], function () {
        Route::get('test-request', [MedicalTestRequestController::class, 'index'])->name('testRequest.index');
        Route::get('test-request/{testRequest}/add-result', [MedicalTestRequestController::class, 'addResult'])->name('testRequest.addResult');
        Route::Patch('test-request/{testRequest}/store-result', [MedicalTestRequestController::class, 'storeResult'])->name('testRequest.storeResult');
    });
});

Route::get('clear_cache', function () {
    $x = Artisan::call('optimize:clear');
    return "Done!";
});
Route::get('_migrate', function(){
    $exitCode = Artisan::call('migrate:fresh', ['--seed' => true]);
    $exitCode = Artisan::call('translations:import');
    return "Done!";
});
Route::get('_route', function(){
    // dd(mb_detect_encoding($foo));
    // dd('5:15' < '5:30');
    // return $foo;
    dd( App\Models\User::where('id', '3_char')->first() );
});
Route::fallback(function(){ return redirect()->route('home')->with('error', __('flashes.pageNotFound')); });
