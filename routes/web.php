<?php

use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoiceDetailController;

// Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware('auth');
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);


require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('invoices',InvoicesController::class);
Route::resource('attachment',InvoiceAttachmentController::class);
Route::get('/sections/{id}',[InvoicesController::class,'getProductsForSection']);
Route::resource('detail',InvoiceDetailController::class);
Route::resource('sections',SectionsController::class);
Route::resource('products',ProductController::class);
Route::get('invoices/status/{id}', [InvoicesController::class, 'getFileStatus'])->name('invoices.getFileStatus');
Route::patch('invoices/status/{id}', [InvoicesController::class, 'updateStatus'])->name('invoices.updateStatus');
// Route::put('invoices/status/{id}', [InvoicesController::class, 'updateStatus'])->name('invoices.updateStatus');
Route::get('/{page}', [AdminController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});













/************************ ********************************/
////expect  route run all routes but are exist in expect()
// Route::resource('mostafa',InvoicesController::class)->expect(['show','store']);
////only route run all method exist in only()
// Route::resource('mostafa',InvoicesController::class)->only(['create','index','destroy','edit','update']);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('test',function(){
//     // return view('test');
//     return response()->json(['stauts'=>'mostafa']);
// });
/************************ ********************************/
