<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InstallmentPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnggotaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::middleware(['access.officer'])->prefix('officer')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'officer'])->name('officer.dashboard');
        Route::get('transaction', [TransactionController::class, 'index'])->name('officer.trx');
        Route::get('transaction/{id}', [TransactionController::class, 'confirmTransaction'])->name('officer.action.payment');
        Route::get('saving/{type}', [SavingController::class, 'index'])->name('officer.savings.index');
        Route::post('saving', [SavingController::class, 'store'])->name('officer.savings.store');
        
        Route::get('loans', [LoanController::class, 'indexOfficer'])->name('officer.loans.index');
        Route::get('installment', [InstallmentPaymentController::class, 'indexOfficer'])->name('officer.loans.installment');
        
        // Payments
        Route::prefix('payment')->group(function() {
            Route::get('menu', [DashboardController::class, 'paymentMenu'])->name('officer.payments.menu');
            Route::get('angsuran', [PaymentController::class, 'angsuranIndex'])->name('officer.payments.angsuran');
            Route::get('simpanan', [PaymentController::class, 'savingIndex'])->name('officer.payments.simpanan');
            Route::get('get-loans/{id}', [InstallmentPaymentController::class, 'getAngsuran'])->name('officer.payments.getLoan');
            Route::post('installmentpayment', [InstallmentPaymentController::class, 'store'])->name('officer.payments.installment.store');
        });
        
        Route::prefix('anggota')->group(function() {
            Route::get('list', [AnggotaController::class, 'index'])->name('officer.members.index');
        });

        Route::prefix('report')->group(function() {
            Route::get('income-outcome-report', [ReportController::class, 'incomeOutcomeView'])->name('officer.report.in.outcome.view');
            Route::post('income-outcome-report', [ReportController::class, 'incomeOutcome'])->name('officer.report.in.outcome');
        });
    });
    Route::middleware(['access.chief'])->prefix('chief')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'chief'])->name('chief.dashboard');
        Route::get('/loan/confirm', [LoanController::class, 'confirmIndex'])->name('chief.confirm.loan.index');
        Route::post('/loan/confirm', [LoanController::class, 'actionConfirm'])->name('chief.confirm.loan.action');
    });
    Route::middleware(['access.member'])->group(function() {
        Route::get('/', [DashboardController::class, 'member'])->name('member.dashboard');
        Route::get('formulir-pengajuan', [ProfileController::class, 'create'])->name('member.form.register');
        Route::post('formulir-pengajuan', [ProfileController::class, 'store'])->name('member.post.form');
        Route::post('confirm-payment', [TransactionController::class, 'store'])->name('member.confirm.payment');

        Route::get('savings', [SavingController::class, 'indexMember'])->name('member.savings.all');
        Route::get('loans', [LoanController::class, 'indexMember'])->name('member.loans.all');
        Route::get('loans/create', [LoanController::class, 'create'])->name('member.loans.create');
        Route::post('loans', [LoanController::class, 'store'])->name('member.loans.store');
        Route::get('loans/{id}', [LoanController::class, 'showMember'])->name('member.loans.show');

        Route::get('slip', [ReportController::class, 'slipMember'])->name('member.slip.index');
    });
});


Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
