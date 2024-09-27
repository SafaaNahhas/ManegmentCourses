<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Services\InstructorService;
use App\Http\Resources\CoursesResource;
use App\Http\Resources\InstructorResource;
use App\Http\Requests\InstructorRequest\StoreInstructorRequest;
use App\Http\Requests\InstructorRequest\UpdateInstructorRequest;

class InstructorController extends Controller
{

protected $instructorService;

/**
 * Constructor to initialize InstructorService.
 *
 * @param \App\Services\InstructorService $instructorService
 */
public function __construct(InstructorService $instructorService)
{
    $this->instructorService = $instructorService;
}

/**
 * Store a newly created instructor along with courses.
 *
 * @param  \App\Http\Requests\InstructorRequest\StoreInstructorRequest  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function store(StoreInstructorRequest $request)
{
    $instructor= $this->instructorService->createInstructor($request->validated());
    return response()->json(new InstructorResource($instructor), 201);
}

/**
 * Display the specified instructor with courses.
 *
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse
 */
public function show($id)
{
    $instructor= $this->instructorService->showInstructor($id);
    return response()->json(new InstructorResource($instructor), 200);
}

/**
 * Display a listing of all instructors with their courses.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function index()
{
    $instructors=$this->instructorService->getAllInstructors();
    return response()->json(InstructorResource::collection($instructors), 200);
}

/**
 * Update the specified instructor along with courses.
 *
 * @param  \App\Http\Requests\InstructorRequest\UpdateInstructorRequest  $request
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse
 */
public function update(UpdateInstructorRequest $request, $id)
{
    $instructor=$this->instructorService->updateInstructor($request->validated(), $id);
    return response()->json(new InstructorResource($instructor), 200);
}

/**
 * Remove the specified instructor and detach their courses.
 *
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse
 */
public function destroy($id)
{
    $this->instructorService->deleteInstructor($id);
    return response()->json(['message' => 'Instructor deleted successfully!'], 200);
}

/**
 * Get courses taught by a specific instructor.
 *
 * @param  int  $instructor_id
 * @return \Illuminate\Http\JsonResponse
 */
public function coursesByInstructor($instructor_id)
{$courses=
    $this->instructorService->getCoursesByInstructor($instructor_id);
    return response()->json(CoursesResource::collection($courses), 200);
}

/**
 * Get students associated with a specific instructor.
 *
 * @param  int  $instructor_id
 * @return \Illuminate\Http\JsonResponse
 */
public function studentsByInstructor($instructor_id)
{
   $students=$this->instructorService->getStudentsByInstructor($instructor_id);
    return response()->json($students, 200);
}
}







