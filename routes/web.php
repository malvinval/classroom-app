<?php

use App\Http\Controllers\ClassroomRegistrarController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MyClassroomController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\StudentAssignmentController;
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

Route::get('/', [SiteController::class, 'index'])->name("home")->middleware(["auth", "verified"]);
Route::get('/c', [SiteController::class, 'classrooms'])->name("classrooms")->middleware(["auth", "verified"]);
Route::get('/c/{classroom:access_code}', [SiteController::class, 'classroom'])->name("classroom")->middleware(["auth", "verified"]);

Route::resource('/mc', MyClassroomController::class)->middleware(["auth", "verified"]);
Route::resource('/f', ForumController::class)->middleware(["auth", "verified"]);
Route::resource('/sa', StudentAssignmentController::class)->middleware(["auth", "verified"]);
Route::resource('/r', ClassroomRegistrarController::class)->except(['index', 'show', 'create', 'edit', 'update'])->middleware(["auth", "verified"]);


Auth::routes(['verify' => true]);