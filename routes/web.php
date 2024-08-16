<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\CostTypeController;
use App\Http\Controllers\ExpenseBadgetController;

Route::get('/', [NewsController::class,'index']);
Route::get('create',[NewsController::class,'create']);
Route::post('insert',[NewsController::class,'insert']);
Route::get('ndelete/{id}',[NewsController::class,'delete'])->name('news.delete');
Route::get('nedit/{id}',[NewsController::class,'edit'])->name('news.edit');
Route::post('nupdate/{id}',[NewsController::class,'update'])->name('news.update');

Route::get('users', [UserController::class,'index']);
Route::get('uCreate',[UserController::class,'create']);
Route::post('uInsert', [UserController::class, 'insert']);
Route::get('uDelete/{id}',[UserController::class,'delete'])->name('users.delete');
Route::get('uedit/{id}',[UserController::class,'edit'])->name('users.edit');
Route::post('uupdate/{id}',[UserController::class,'update'])->name('users.update');

Route::get('year',[YearController::class,'index']);
Route::get('yCreate',[YearController::class,'create']);
Route::post('yInsert',[YearController::class,'insert']);
Route::get('yDelete/{id}',[YearController::class,'delete'])->name('years.delete');
Route::get('edit/{id}',[YearController::class,'edit'])->name('years.edit');
Route::post('update/{id}',[YearController::class,'update'])->name('years.update');

Route::get('Expense',[ExpenseBadgetController::class,'index']);
Route::get('ExCreate',[ExpenseBadgetController::class,'create']);
Route::post('ExInsert',[ExpenseBadgetController::class,'insert']);
Route::get('exDelete/{id}',[ExpenseBadgetController::class,'delete'])->name('ex.delete');
Route::get('exedit/{id}',[ExpenseBadgetController::class,'edit'])->name('ex.edit');
Route::post('exupdate/{id}',[ExpenseBadgetController::class,'update'])->name('ex.update');

Route::get('cost_type',[CostTypeController::class,'index']);
Route::get('costCreate',[CostTypeController::class,'create']);
Route::post('costInsert',[CostTypeController::class,'insert']);
Route::get('costDelete/{id}',[CostTypeController::class,'delete'])->name('costs.delete');
Route::get('costedit/{id}',[CostTypeController::class,'edit'])->name('costs.edit');
Route::post('costupdate/{id}',[CostTypeController::class,'update'])->name('costs.update');

