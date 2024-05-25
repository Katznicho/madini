<?php

use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return redirect('admin');
});

Route::get('finishPayment', [PaymentController::class, 'finishPayment'])->name('finishPayment');
Route::get('cancelPayment', [PaymentController::class, 'cancelPayment'])->name('cancelPayment');
