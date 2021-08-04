<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DoctorDataController;
use App\Http\Controllers\Admin\PatientFileController;

Route::namespace('Auth')->group(function(){
    //Login Routes
    Route::get('/login','LoginController@showLoginForm')->name('login')->middleware('guest:admin');
    Route::post('/login','LoginController@login')->middleware('guest:admin');
    Route::post('/logout','LoginController@logout')->name('logout')->middleware('auth:admin');

    /*
        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');
    */
});

Route::middleware('auth:admin')->group(function(){

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::view('settings/translations', 'admin.settings.translations')->name('settings.translations'); // Translations UI

    Route::get('user/type/{job}', 'UserController@usersByJob')->name('user.usersByJob');

    Route::get('role/admins', 'RoleController@adminsRoles')->name('role.admins');
    Route::get('role/users', 'RoleController@usersRoles')->name('role.users');
    Route::get('role/{role}', 'RoleController@show')->name('role.show');
    Route::get('role/create/{param}', 'RoleController@createFor')->name('role.createFor');
    Route::post('role/store', 'RoleController@store')->name('role.store');
    Route::get('role/edit/{role}/{param}', 'RoleController@editFor')->name('role.editFor');
    Route::patch('role/{role}/update', 'RoleController@update')->name('role.update');
    Route::delete('role/{role}', 'RoleController@destroy')->name('role.destroy');

    Route::get('patient/blocked', [App\Http\Controllers\PatientController::class, 'blockedPatients'])->name('patient.blockedPatients');
    Route::get('patient/emergency', [App\Http\Controllers\PatientController::class, 'emergencyPatients'])->name('patient.emergencyPatients');
    Route::get('patient/{patient}/reservations', [App\Http\Controllers\PatientController::class, 'reservations'])->name('patient.reservations');
    // Route::get('patient/{patient}/diagnoses', [App\Http\Controllers\PatientController::class, 'diagnoses'])->name('patient.diagnoses');

    Route::get('reservations', [App\Http\Controllers\ReservationController::class, 'index'])->name('reservation.index');
    Route::get('reservations/search', [App\Http\Controllers\ReservationController::class, 'search'])->name('reservation.search');

    Route::get('doctor/{user}/create', [DoctorDataController::class, 'create'])->name('doctorData.create');
    Route::post('doctor/{user}/store', [DoctorDataController::class, 'store'])->name('doctorData.store');
    Route::get('doctor/{user}/edit', [DoctorDataController::class, 'edit'])->name('doctorData.edit');
    Route::patch('doctor/{user}/update', [DoctorDataController::class, 'update'])->name('doctorData.update');
    Route::get('doctor/{user}/reservations', [DoctorDataController::class, 'reservations'])->name('doctorData.reservations');

    Route::post('reservation/change-status', [App\Http\Controllers\ReservationController::class, 'changeStatus'])->name('reservation.changeStatus');

    Route::get('clinic/{clinic}/appointments', 'ClinicController@editAppointments')->name('clinic.editAppointments');
    Route::patch('clinic/{clinic}/appointments', 'ClinicController@updateAppointments')->name('clinic.updateAppointments');
    Route::get('clinic/{clinic}/reservations', 'ClinicController@reservations')->name('clinic.reservations');

    Route::get('rays-requests', [App\Http\Controllers\RaysRequestController::class, 'index'])->name('rays-requests.index');
    Route::delete('rays-requests/{rayRequest}', [App\Http\Controllers\DoctorController::class, 'destroyRaysRequest'])->name('rays-requests.destroy');

    Route::get('medical-test/requests', [App\Http\Controllers\MedicalTestRequestController::class, 'index'])->name('medical-test.requests');
    Route::delete('medical-test/requests/{testRequest}', [App\Http\Controllers\DoctorController::class, 'destroyTestRequest'])->name('medical-test.request.destroy');

    Route::get('company/{company}/patients', [CompanyController::class, 'patients'])->name('company.patients');

    Route::resource('patient.files', \PatientFileController::class)->except('show');
    Route::resource('discount', DiscountController::class)->except('show');
    Route::resource('room', RoomController::class)->except('show');
    Route::resources([
        'patient' => '\App\Http\Controllers\PatientController',
        'user' => UserController::class,
        'admin' => AdminController::class,
        'clinic' => ClinicController::class,
        'rays' => RaysController::class,
        'medical-test' => MedicalTestController::class,
        'company' => \CompanyController::class,
    ]);

});
