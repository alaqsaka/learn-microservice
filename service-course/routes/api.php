<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ImageCourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MyCourseController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Course Routes
Route::post('courses', [CourseController::class, 'create']);
Route::get('courses', [CourseController::class, 'index']);
Route::put('courses/{id}', [CourseController::class, 'update']);
Route::delete('courses/{id}', [CourseController::class, 'destroy']);
// Detail Course
Route::get('courses/{id}', [CourseController::class, 'show']);

// Mentor routes
Route::post('mentors', [MentorController::class, 'create']);
Route::put('mentors/{id}', [MentorController::class, 'update']);
Route::get('mentors', [MentorController::class, 'index']);
Route::get('mentors/{id}', [MentorController::class, 'show']);
Route::delete('mentors/{id}', [MentorController::class, 'destroy']);

// Chapter routes
Route::post('chapters', [ChapterController::class, 'create']);
Route::put('chapters/{id}', [ChapterController::class, 'update']);
Route::get('chapters', [ChapterController::class, 'index']);
Route::get('chapters/{id}', [ChapterController::class, 'show']);
Route::delete('chapters/{id}', [ChapterController::class, 'destroy']);

// Lesson Routes
Route::post('lessons', [LessonController::class, 'create']);
Route::put('lessons/{id}', [LessonController::class, 'update']);
Route::get('lessons', [LessonController::class, 'index']);
Route::get('lessons/{id}', [LessonController::class, 'show']);
Route::delete('lessons/{id}', [LessonController::class, 'destroy']);

// Image Course Routes
Route::post('image-courses', [ImageCourseController::class, 'create']);
Route::delete('image-courses/{id}', [ImageCourseController::class, 'destroy']);

// MyCourses
Route::post('my-courses', [MyCourseController::class, 'create']);
Route::get('my-courses', [MyCourseController::class, 'index']);

// Reviews
Route::post('reviews', [ReviewController::class, 'create']);
Route::put('reviews/{id}', [ReviewController::class, 'update']);
Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);
