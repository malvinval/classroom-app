<?php

use App\Http\Controllers\ClassroomRegistrarController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MyClassroomController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [SiteController::class, 'index'])->name("home")->middleware("auth");
Route::get('/c', [SiteController::class, 'classrooms'])->name("classrooms")->middleware("auth");
Route::get('/c/{classroom:access_code}', [SiteController::class, 'classroom'])->name("classroom")->middleware("auth");

Route::resource('/mc', MyClassroomController::class)->middleware("auth");
Route::resource('/f', ForumController::class)->middleware("auth");

Route::post('/join', [ClassroomRegistrarController::class, 'store'])->middleware("auth");

Auth::routes(['verify' => true]);