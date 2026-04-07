<?php

use App\Http\Controllers\Company\CompanyAssetController;
use App\Http\Controllers\Company\CompanyAssetScanQrController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'access_permission'])->group(function () {

    Route::group(["controller" => CompanyAssetController::class, "prefix" => "company_asset", "as" => "company_asset."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
    });
    Route::group(["controller" => CompanyAssetScanQrController::class, "prefix" => "company_asset_scan_qr", "as" => "company_asset_scan_qr."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('{id}/create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');;
    });
});
