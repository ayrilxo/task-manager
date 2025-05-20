<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Route::resource('tasks', TaskController::class);

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('/tasks/create',[TaskController::class,'create'])->name('tasks.create');

Route::post('/tasks/store',[TaskController::class,'store'])->name('tasks.store');

Route::get('/tasks/edit/{id}',[TaskController::class,'edit'])->name('tasks.edit');

Route::post('/tasks/update/{id}',[TaskController::class,'update'])->name('tasks.update');

Route::post('/tasks/delete/{id}',[TaskController::class,'destroy'])->name('tasks.delete');

Route::get('/tasks/incomplete',[TaskController::class,'incomplete'])->name('tasks.incomplete');


