<?php

use App\Http\Controllers\admin\NetworkController;
use App\Livewire\Web\Account\EditAccount;
use App\Livewire\Web\Faq\Faq;
use App\Livewire\Web\Withdraw\ListWithdraw;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DepositController;
use App\Http\Controllers\admin\InvestorController;
use App\Http\Controllers\admin\PlanController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\WalletController;
use App\Http\Controllers\admin\WithdrawController;
use App\Http\Controllers\admin\ReferralController;
use App\Http\Controllers\admin\CoinController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\AuthController as ControllersAuthController;
use App\Http\Controllers\LanguageController;
use App\Livewire\Web\Deposit\ListDeposit;
use App\Livewire\Web\Aboutus\Aboutus;
use App\Livewire\Web\Account\Account;
use App\Livewire\Web\Auth\Login;
use App\Livewire\Web\Auth\Recover;
use App\Livewire\Web\Auth\Register;
use App\Livewire\Web\Bounty\Bounty;
use App\Livewire\Web\Deposit\Deposit;
use App\Livewire\Web\Referal\Referal;
use App\Livewire\Web\Home\Index;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Mail\Sendmail;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::fallback(function () {
    return view('web.errors.404');
});


Route::get('/send-email', function () {
    Mail::to('nguyendacphuong14@gmail.com')->send(new Sendmail()); // Ensure TestMail implements Mailable
    return 'Email sent successfully!';
});

// .......................................................................BEGIN............................................................................
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    return "All caches are cleared";
});

Route::get('/storage-link', function () {
    $target = $_SERVER['DOCUMENT_ROOT'] . '/storage/app/public';
    $shortcut = $_SERVER['DOCUMENT_ROOT'] . '/public/storage';
    symlink($target, $shortcut);
});

Route::get('/register', Register::class);
Route::get('/register/success', function () {
    return view('web.layouts.register-success');
});
Route::get('/login', Login::class);
Route::get('/recover', Recover::class);
Route::get('/logout', [ControllersAuthController::class, 'logout']);
// verify
Route::get('/verify-email/{id}', [ControllersAuthController::class, 'verifyEmail']);
// page
Route::get('/', Index::class)->name('home');
Route::get('/aboutus', Aboutus::class);
Route::get('/bounty', Bounty::class);
Route::get('/faq', Faq::class);
// manager investor
Route::get('/account', Account::class);
Route::get('/deposit', Deposit::class);
Route::get('/list-deposit', ListDeposit::class);
Route::get('/withdraw', ListWithdraw::class);
Route::get('/edit-account', EditAccount::class);
Route::get('/referrals', Referal::class);

// .......................................................................END............................................................................


// manage admin
Route::group(['prefix' => 'admin'], function () {
    // lang
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);
    // auth
    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', [AuthController::class, 'index'])->name('login');
        Route::post('login', [AuthController::class, 'post_login'])->name('post_login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
    // management
    Route::group(['middleware' => ['auth']], function () {
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        // user
        Route::get('list-user', [UserController::class, 'index'])->name('users')->middleware('can:list-user');
        // roles
        Route::get('list-role', [RoleController::class, 'index'])->name('roles')->middleware('can:list-role');
        // investor
        Route::get('list-investor', [InvestorController::class, 'index'])->name('investors')->middleware('can:list-investor');
        Route::post('investor/get', [InvestorController::class, 'filterDataTable'])->name('investor.list');
        Route::post('investor/create', [InvestorController::class, 'store'])->name('investor.create');
        Route::post('investor/update', [InvestorController::class, 'update'])->name('investor.update');
        Route::post('investor/delete', [InvestorController::class, 'destroy'])->name('investor.delete');
        Route::post('investor/detail', [InvestorController::class, 'show'])->name('investor.detail');
        Route::get('investor/history/deposit/{id}', [InvestorController::class, 'historyDeposit'])->name('history.deposit');
        // Route::post('investor/history/deposit', [InvestorController::class, 'depositDatatable'])->name('history.deposit');
        Route::get('investor/history/withdraw/{id}', [InvestorController::class, 'history_withdraw'])->name('history.withdraw');
        // wallets
        Route::get('list-wallets/{id}', [WalletController::class, 'index'])->name('wallets')->middleware('can:list-wallets');
        Route::post('wallet/create', [WalletController::class, 'store'])->name('wallet.create');
        Route::post('wallet/update', [WalletController::class, 'update'])->name('wallet.update');
        Route::post('wallet/get', [WalletController::class, 'filterDataTable'])->name('wallet.list');
        Route::post('wallet/delete', [WalletController::class, 'destroy'])->name('wallet.delete');
        // network
        Route::get('list-network', [NetworkController::class, 'index'])->name('network')->middleware('can:list-network');
        Route::post('network/get', [NetworkController::class, 'filterDataTable'])->name('network.list');
        Route::post('network/create', [NetworkController::class, 'store'])->name('network.create');
        Route::post('network/update', [NetworkController::class, 'update'])->name('network.update');
        Route::post('network/delete', [NetworkController::class, 'destroy'])->name('network.delete');

        Route::get('list-coin', [CoinController::class, 'index'])->name('coin')->middleware('can:list-coin');
        Route::get('list-profit', [CoinController::class, 'profit'])->name('profit')->middleware('can:list-coin');
        // plan fixed
        Route::get('list-plan-fixeds', [PlanController::class, 'plan_fixed'])->name('plans-fixeds')->middleware('can:list-plan');
        // plan daily
        Route::get('list-plan-daily', [PlanController::class, 'plan_daily'])->name('plans-daily')->middleware('can:list-plan');
        // deposit
        Route::get('list-deposit', [DepositController::class, 'index'])->name('deposits')->middleware('can:list-deposit');
        // withdraw
        Route::get('list-withdraw', [WithdrawController::class, 'index'])->name('withdraws')->middleware('can:list-withdraw');
        // referral
        Route::get('list-referral', [ReferralController::class, 'index'])->name('referrals')->middleware('can:list-referral');
        // settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings');
    });
});
// .......................................................................END............................................................................