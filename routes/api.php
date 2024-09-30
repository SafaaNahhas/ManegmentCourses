<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InstructorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api', 'is_admin'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);


    Route::post('courses/{course}/attach-instructor', [CourseController::class, 'attachInstructorToCourse']);
    Route::post('courses/{course}/attach-student', [CourseController::class, 'attachStudentToCourse']);
    Route::apiResource('courses', CourseController::class);

    Route::apiResource('instructors', InstructorController::class);
    Route::get('/instructors/{id}/courses', [InstructorController::class, 'coursesByInstructor']);
    Route::get('/instructors/{id}/students', [InstructorController::class, 'studentsByInstructor']);

    Route::apiResource('students', StudentController::class);
    Route::post('/students/{id}/courses', [StudentController::class, 'registerToCourses']);
    Route::get('/courses/{id}/students', [StudentController::class, 'studentsInCourse']);
});
