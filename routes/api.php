<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PPOBController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TransferLPDController;
use App\Http\Controllers\TransferBankController;
use App\Http\Controllers\TransfereLinkController;

// Route::get('/login', function () {
//     return('test');
// });


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/aktivitas', [AuthController::class, 'activity']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::post('/access/token', [AccessController::class, 'Token']);
Route::post('/access/register', [AccessController::class, 'Register']);
Route::post('/access/login', [AccessController::class, 'Login']);
Route::post('/access/change-pass', [AccessController::class, 'ChangePass']);
Route::post('/access/change-pin', [AccessController::class, 'ChangePIN']);

Route::post('/tabungan/list-account', [TabunganController::class, 'ListAccount']);
Route::post('/tabungan/history-account', [TabunganController::class, 'HistoryAccount']);
Route::post('/deposito/history-account', [TabunganController::class, 'HistoryDeposito']);
Route::post('/pinjaman/list-account', [TabunganController::class, 'ListPinjaman']);
Route::post('/pinjaman/history-account', [TabunganController::class, 'HistoryPinjaman']);

Route::post('/account/save', [AccountController::class, 'SaveAccount']);
Route::post('/account/delete', [AccountController::class, 'DeleteAccount']);

Route::post('/transfer-lpd/check-account', [TransferLPDController::class, 'CheckAccount']);
Route::post('/transfer-lpd/inquiryTransfer', [TransferLPDController::class, 'InquiryTransfer']);
Route::post('/transfer-lpd/postingTransfer', [TransferLPDController::class, 'PostingTransfer']);

if (env('APP_POLICY') == 'elink'){
    Route::post('/transfer-bank/check-account', [TransfereLinkController::class, 'CheckAccount']);
    Route::post('/transfer-bank/inquiryTransfer', [TransfereLinkController::class, 'InquiryTransfer']);
    Route::post('/transfer-bank/postingTransfer', [TransfereLinkController::class, 'PostingTransfer']);
}else if (env('APP_POLICY') == 'development' || env('APP_POLICY') == 'production'){
    Route::post('/transfer-bank/check-account', [TransferBankController::class, 'CheckAccount']);
    Route::post('/transfer-bank/inquiryTransfer', [TransferBankController::class, 'InquiryTransfer']);
    Route::post('/transfer-bank/postingTransfer', [TransferBankController::class, 'PostingTransfer']);
}

Route::post('/ppob/check-account', [PPOBController::class, 'CheckAccount']);
Route::post('/ppob/payment', [PPOBController::class, 'Payment']);
