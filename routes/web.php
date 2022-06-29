<?php

use App\Http\Controllers\ClassroomRegistrarController;
use App\Http\Controllers\CommentController;
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

Route::get('/', [SiteController::class, 'index'])->name("home")->middleware("auth");
Route::get('/c', [SiteController::class, 'classrooms'])->name("classrooms")->middleware("auth");
Route::get('/c/{classroom:access_code}', [SiteController::class, 'classroom'])->name("classroom")->middleware("auth");
Route::get('/join-classroom', [SiteController::class, 'test'])->name("join-classroom")->middleware("auth");
Route::get('/reply-comment/{comment:id}',[SiteController::class, 'reply'])->middleware("auth");
Route::get('/comment/{forum:id}/{comment:sender_id}', [CommentController::class, 'show'])->middleware("auth");

Route::resource('/mc', MyClassroomController::class)->middleware("auth");
Route::resource('/f', ForumController::class)->middleware("auth");
Route::resource('/sa', StudentAssignmentController::class)->middleware("auth");
Route::resource('/r', ClassroomRegistrarController::class)->except(['index', 'show', 'create', 'edit', 'update'])->middleware("auth");
Route::resource('/comment', CommentController::class)->middleware("auth");

Auth::routes(['verify' => true]);