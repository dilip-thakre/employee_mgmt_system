<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\GmailOAuthController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'index'])->name('admin.login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::get('registration', [EmployeeController::class,'showRegistrationForm'])->name('register-user');
Route::post('custom-registration', [EmployeeController::class,'register'])->name('register.custom');
Route::get('upload-employee', [EmployeeController::class,'upload_employee'])->name('upload.employees');


Route::post('upload-employee-data', [EmployeeController::class,'upload_employee_data'])->name('upload.employees-data');
Route::get('/employees/download', [EmployeeController::class, 'download'])->name('employees.download');

Route::get('employees', [EmployeeController::class,'index'])->name('employees.index');
Route::get('employees/search', [EmployeeController::class,'search'])->name('employees.search');
Route::get('/employees/{id}/edit', [EmployeeController::class,'edit'])->name('employees.edit');
Route::put('/employees/{id}', [EmployeeController::class,'update'])->name('employees.update');
Route::delete('/employees/{id}', [EmployeeController::class,'delete'])->name('employees.delete');
Route::get('gmail', [EmployeeController::class,'gmail'])->name('employees.gmail');

Route::get('/oauth/login', [GmailOAuthController::class,'login'])->name('oauth.login');
Route::get('/oauth/logout', [GmailOAuthController::class,'logout'])->name('oauth.logout');
