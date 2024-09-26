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
        Route::group(['prefix' => 'user'], function () {
            Route::get('/list', [UserController::class, 'index'])->name('users')->middleware('can:list-user');
            Route::post('/get', [UserController::class, 'filterDataTable'])->name('user.list');
            Route::post('/create', [UserController::class, 'create'])->name('user.create');
            Route::post('/update', [UserController::class, 'update'])->name('user.update');
            Route::post('/delete', [UserController::class, 'destroy'])->name('user.delete');
        });
        // roles
        Route::group(['prefix' => 'role'], function () {
            Route::get('/list', [RoleController::class, 'index'])->name('roles')->middleware('can:list-role');
            Route::get('/get', [RoleController::class, 'getRoles'])->name('getRoles');
            Route::post('/create', [RoleController::class, 'store'])->name('create.role');
            Route::post('/update', [RoleController::class, 'update'])->name('update.role');
            Route::get('/edit/{id}', [RoleController::class, 'show'])->name('edit.role');
            Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('delete-role');
        });
        // investor
        Route::group(['prefix' => 'investor'], function () {
            Route::get('/list', [InvestorController::class, 'index'])->name('investors')->middleware('can:list-investor');
            Route::post('/get', [InvestorController::class, 'filterDataTable'])->name('investor.list');
            Route::post('/create', [InvestorController::class, 'store'])->name('investor.create');
            Route::post('/update', [InvestorController::class, 'update'])->name('investor.update');
            Route::post('/delete', [InvestorController::class, 'destroy'])->name('investor.delete');
            Route::post('/detail', [InvestorController::class, 'show'])->name('investor.detail');
            Route::get('/history/deposit/{id}', [InvestorController::class, 'historyDeposit'])->name('history.deposit');
            // Route::post('/history/deposit', [InvestorController::class, 'depositDatatable'])->name('history.deposit');
            // Route::get('/history/withdraw/{id}', [InvestorController::class, 'history_withdraw'])->name('history.withdraw');
        });
        // wallets
       
        Route::get('list-wallets/{id}', [WalletController::class, 'index'])->name('wallets')->middleware('can:list-wallets');
        Route::post('wallet/create', [WalletController::class, 'store'])->name('wallet.create');
        Route::post('wallet/update', [WalletController::class, 'update'])->name('wallet.update');
        Route::post('wallet/get', [WalletController::class, 'filterDataTable'])->name('wallet.list');
        Route::post('wallet/delete', [WalletController::class, 'destroy'])->name('wallet.delete');

        // network
        Route::group(['prefix' => 'network'], function () {
            Route::get('/list', [NetworkController::class, 'index'])->name('network')->middleware('can:list-network');
            Route::post('/get', [NetworkController::class, 'filterDataTable'])->name('network.list');
            Route::post('/create', [NetworkController::class, 'store'])->name('network.create');
            Route::post('/update', [NetworkController::class, 'update'])->name('network.update');
            Route::post('/delete', [NetworkController::class, 'destroy'])->name('network.delete');
        });

        // coins
        Route::group(['prefix' => 'coin'], function () {
            Route::get('list', [CoinController::class, 'index'])->name('coins')->middleware('can:list-coin');
            Route::post('/get', [CoinController::class, 'filterDataTable'])->name('coin.list');
            Route::post('/create', [CoinController::class, 'store'])->name('coin.create');
            Route::post('/update', [CoinController::class, 'update'])->name('coin.update');
            Route::post('/delete', [CoinController::class, 'destroy'])->name('coin.delete');
        });
        // plan
        Route::group(['prefix' => 'plan'], function () {
            Route::get('/list', [PlanController::class, 'index'])->name('plans')->middleware('can:list-plan');
            Route::post('/get', [PlanController::class, 'filterDataTable'])->name('plan.list');
            Route::post('/create', [PlanController::class, 'store'])->name('plan.create');
            Route::post('/update', [PlanController::class, 'update'])->name('plan.update');
            Route::post('/delete', [PlanController::class, 'destroy'])->name('plan.delete');
            Route::post('/delete/item', [PlanController::class, 'delete'])->name('item.delete');
        });
        // deposit
        Route::group(['prefix' => 'deposit'], function () {
            Route::get('/list', [DepositController::class, 'index'])->name('deposits')->middleware('can:list-deposit');
            Route::post('/get', [DepositController::class, 'filterDataTable'])->name('deposit.list');
            Route::post('/confirm', [DepositController::class, 'confirm'])->name('deposit.confirm');
            Route::post('/cancel', [DepositController::class, 'cancel'])->name('deposit.cancel');
        });
        // withdraw
        Route::group(['prefix' => 'withdraw'], function () {
            Route::get('/list', [WithdrawController::class, 'index'])->name('withdraws')->middleware('can:list-withdraw');
            Route::post('/get', [WithdrawController::class, 'filterDataTable'])->name('withdraw.list');
            Route::post('/confirm', [WithdrawController::class, 'confirm'])->name('withdraw.confirm');
            Route::post('/cancel', [WithdrawController::class, 'cancel'])->name('withdraw.cancel');
        });
        // referral
        Route::group(['prefix' => 'referral'], function () {
            Route::get('/list', [ReferralController::class, 'index'])->name('referrals')->middleware('can:list-referral');
            Route::post('/get', [ReferralController::class, 'filterDataTable'])->name('referral.list');
        });
        // settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings');
        Route::get('get', [SettingController::class, 'get'])->name('setting.get');
        Route::post('setting/create', [SettingController::class, 'store'])->name('setting.create');
        Route::post('setting/delete', [SettingController::class, 'destroy'])->name('setting.delete');
    });
});
// .......................................................................END............................................................................