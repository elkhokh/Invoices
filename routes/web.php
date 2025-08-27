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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

// Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware('auth');
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);


require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/sections/{id}', [InvoicesController::class, 'getProductsForSection']);
Route::get('invoices/status/{id}', [InvoicesController::class, 'getFileStatus'])->name('invoices.getFileStatus');
Route::patch('invoices/status/{id}', [InvoicesController::class, 'updateStatus'])->name('invoices.updateStatus');
Route::get('invoices/paid', [InvoicesController::class, 'paidStatus'])->name('invoices.paid');
Route::get('invoices/unpaid', [InvoicesController::class, 'unpaidStatus'])->name('invoices.unpaid');
Route::get('invoices/partialPaid', [InvoicesController::class, 'partialPaidStatus'])->name('invoices.partialPaid');
Route::get('invoices/archive', [InvoicesController::class, 'showArchive'])->name('invoices.archive');
Route::delete('invoices/force/{id}', [InvoicesController::class, 'forceDelete'])->name('invoices.forceDelete');
Route::patch('invoices/restore/{id}', [InvoicesController::class, 'restore'])->name('invoices.restore');
Route::post('invoices/print/{id}', [InvoicesController::class, 'printInvoice'])->name('invoices.print');
Route::get('invoices/export/', [InvoicesController::class, 'export'])->name('invoices.export');

Route::resources([
    'attachment' => InvoiceAttachmentController::class,
    'detail'     => InvoiceDetailController::class,
    'sections'   => SectionsController::class,
    'products'   => ProductController::class,
    'invoices'   => InvoicesController::class,
]);



// Route::resource('attachment',InvoiceAttachmentController::class);
// Route::get('/sections/{id}',[InvoicesController::class,'getProductsForSection']);
// Route::resource('detail',InvoiceDetailController::class);
// Route::resource('sections',SectionsController::class);
// Route::resource('products',ProductController::class);
// Route::get('invoices/status/{id}', [InvoicesController::class, 'getFileStatus'])->name('invoices.getFileStatus');
// Route::patch('invoices/status/{id}', [InvoicesController::class, 'updateStatus'])->name('invoices.updateStatus');
// Route::get('invoices/paid', [InvoicesController::class, 'paidStatus'])->name('invoices.paid');
// Route::get('invoices/unpaid', [InvoicesController::class, 'unpaidStatus'])->name('invoices.unpaid');
// Route::get('invoices/partialPaid', [InvoicesController::class, 'partialPaidStatus'])->name('invoices.partialPaid');
// Route::resource('invoices',InvoicesController::class);

// Route::put('invoices/status/{id}', [InvoicesController::class, 'updateStatus'])->name('invoices.updateStatus');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth']], function() {
    // Route::resources([
    //     'roles' => RoleController::class,
    //     'users' => UserController::class,
    // ]);
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);

});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//call pages using var with url
Route::get('/{page}', [AdminController::class, 'index']);












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



// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\InvoicesController;
// use App\Http\Controllers\InvoiceAttachmentController;
// use App\Http\Controllers\InvoiceDetailController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\SectionsController;
// use App\Http\Controllers\ProfileController;

// /*
// |--------------------------------------------------------------------------
// | Authentication Routes
// |--------------------------------------------------------------------------
// */
// require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return view('auth.login');
// });

// /*
// |--------------------------------------------------------------------------
// | Invoice Routes
// |--------------------------------------------------------------------------
// */
// Route::resource('invoices', InvoicesController::class);
// Route::get('invoices/status/{id}', [InvoicesController::class, 'getFileStatus'])->name('invoices.getFileStatus');
// Route::patch('invoices/status/{id}', [InvoicesController::class, 'updateStatus'])->name('invoices.updateStatus');

// Route::get('invoices/paid', [InvoicesController::class, 'paidStatus'])->name('invoices.paidStatus');
// Route::get('invoices/unpaid', [InvoicesController::class, 'unpaidStatus'])->name('invoices.unpaidStatus');
// Route::get('invoices/partialPaid', [InvoicesController::class, 'partialPaidStatus'])->name('invoices.partialPaidStatus');

// /*
// |--------------------------------------------------------------------------
// | Invoice Details & Attachments
// |--------------------------------------------------------------------------
// */
// Route::resource('attachment', InvoiceAttachmentController::class);
// Route::resource('detail', InvoiceDetailController::class);

// /*
// |--------------------------------------------------------------------------
// | Products & Sections
// |--------------------------------------------------------------------------
// */
// Route::resource('sections', SectionsController::class);
// Route::resource('products', ProductController::class);
// Route::get('/sections/{id}', [InvoicesController::class, 'getProductsForSection']);

// /*
// |--------------------------------------------------------------------------
// | Dashboard
// |--------------------------------------------------------------------------
// */
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// /*
// |--------------------------------------------------------------------------
// | Roles & Users (Auth Protected)
// |--------------------------------------------------------------------------
// */
// Route::group(['middleware' => ['auth']], function () {
//     Route::resource('roles', 'RoleController');
//     Route::resource('users', 'UserController');
// });

// /*
// |--------------------------------------------------------------------------
// | Profile (Auth Protected)
// |--------------------------------------------------------------------------
// */
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// /*
// |--------------------------------------------------------------------------
// | Logs
// |--------------------------------------------------------------------------
// */
// Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

// /*
// |--------------------------------------------------------------------------
// | Catch-All Route (MUST be last)
// |--------------------------------------------------------------------------
// */
// Route::get('/{page}', [AdminController::class, 'index']);
