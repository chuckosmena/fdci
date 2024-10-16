<?php

use Illuminate\Support\Facades\Route;

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
    return redirect(route('home'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/thank-you', [App\Http\Controllers\ThankYouController::class, 'index'])->name('thank-you');

Route::group(['prefix' => 'contacts', 'as' => 'contacts.', 'middleware' => 'auth'], function() {
	Route::get('/', [App\Http\Controllers\ContactsController::class, 'index'])->name('index');
	Route::get('create', [App\Http\Controllers\ContactsController::class, 'create'])->name('create');
	Route::post('create', [App\Http\Controllers\ContactsController::class, 'store'])->name('store');
	Route::get('{contact}/edit', [App\Http\Controllers\ContactsController::class, 'edit'])->name('edit');
	Route::post('{contact}/edit', [App\Http\Controllers\ContactsController::class, 'update'])->name('update');
	Route::get('{contact}/delete', [App\Http\Controllers\ContactsController::class, 'delete'])->name('delete');
	Route::get('search', [App\Http\Controllers\ContactsController::class, 'search'])->name('search');
});