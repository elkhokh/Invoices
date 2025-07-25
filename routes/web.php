<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});


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
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('test',function(){
//     // return view('test');
//     return response()->json(['stauts'=>'mostafa']);
// });
/************************ ********************************/
