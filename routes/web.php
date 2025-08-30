<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoicesReportsController;
use App\Http\Controllers\CustomersReportsController;
use App\Http\Controllers\InvoiceAttachmentController;

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
Route::get('reportsin/index', [InvoicesReportsController::class ,'index'])->name('reportsin.index');
Route::post('reportsin/search', [InvoicesReportsController::class ,'search'])->name('reportsin.search');
Route::get('reportscu/index', [CustomersReportsController::class ,'index'])->name('reportscu.index');
Route::post('reportscu/search', [CustomersReportsController::class ,'search'])->name('reportscu.search');



//Resources Routes
Route::resources([
    'attachment' => InvoiceAttachmentController::class,
    'detail'     => InvoiceDetailController::class,
    'sections'   => SectionsController::class,
    'products'   => ProductController::class,
    'invoices'   => InvoicesController::class,
]);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


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

// Route::get("test-posts" , function(){
//     $res = Http::get("https://jsonplaceholder.typicode.com/posts");
//     if($res->successful()){
//         $posts = $res->json();
//         // request success
//     } elseif($res->clientError()){
//     } elseif($res->serverError()){
//     }
//     return response()->json($posts);
// });

// Route::post("add-post" , function(){
//     $res = Http::post("https://jsonplaceholder.typicode.com/posts",[
//         "title" => "first title with api",
//         "content" => "first content with api",
//         "userId" => 10,
//     ]);
//     return $res->json();
// });
/************************ ********************************/
