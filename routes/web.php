<?php

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileExplorerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', function(){
        return redirect()->route('home');
    }); 
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    //users
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

    //clients
    Route::get('clients', [ClientController::class, 'index'])->name('clients');
    Route::get('clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('clients/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
   
    // Notices
    Route::get('notices', [NoticeController::class, 'index'])->name('notices');
    Route::get('notices/create', [NoticeController::class, 'create'])->name('notices.create');
    Route::post('notices/store', [NoticeController::class, 'store'])->name('notices.store');
    Route::get('notices/edit/{notice}', [NoticeController::class, 'edit'])->name('notices.edit');
    Route::put('notices/update/{notice}', [NoticeController::class, 'update'])->name('notices.update');
    Route::get('notices/change/{notice}', [NoticeController::class, 'change'])->name('notices.change');
    Route::delete('notices/{notice}', [NoticeController::class, 'destroy'])->name('notices.destroy');

    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator');
    Route::post('/calculate-tax', [CalculatorController::class, 'calculate'])->name('calculate.tax');

    //fileManager

    Route::get('/file-manager/{folder?}', [FileExplorerController::class, 'index'])->where('folder', '.*')->name('file.manager');
    Route::get('/file-managers/download/{path}', [FileExplorerController::class, 'download'])->where('path', '.*')->name('file.download');
    Route::delete('/file-managers/delete', [FileExplorerController::class, 'delete'])->name('file.delete');
});


Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
});
