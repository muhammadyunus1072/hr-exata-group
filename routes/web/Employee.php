<?php

use App\Http\Controllers\Employee\EmployeeCareerStatusController;
use App\Http\Controllers\Employee\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'access_permission'])->group(function () {

    Route::group(["controller" => EmployeeController::class, "prefix" => "employee", "as" => "employee."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
    });
    Route::group(["controller" => EmployeeCareerStatusController::class, "prefix" => "employee_career_status", "as" => "employee_career_status."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
    });
});
