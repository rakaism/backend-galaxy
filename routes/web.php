<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SalaryRequestController;

Route::middleware(['auth'])->group(function () {
    Route::get('salary-requests', [SalaryRequestController::class, 'index'])->name('salary_requests.index');
    Route::get('salary-requests/create', [SalaryRequestController::class, 'create'])->name('salary_requests.create');
    Route::post('salary-requests', [SalaryRequestController::class, 'store'])->name('salary_requests.store');
    Route::get('salary-requests/{id}/approve', [SalaryRequestController::class, 'approveForm'])->name('salary_requests.approveForm');
    Route::post('salary-requests/{id}/approve', [SalaryRequestController::class, 'approve'])->name('salary_requests.approve');
    Route::get('salary-requests/{id}/pay', [SalaryRequestController::class, 'payForm'])->name('salary_requests.payForm');
    Route::post('salary-requests/{id}/pay', [SalaryRequestController::class, 'pay'])->name('salary_requests.pay');
});

Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::post('login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/salary-requests');
    }
    return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
})->name('login.post');

Route::post('logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
