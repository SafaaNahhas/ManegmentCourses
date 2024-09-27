<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Resources\StudentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\StudentRequest\StoreStudentRequest;
use App\Http\Requests\StudentRequest\UpdateStudentRequest;
use App\Http\Requests\StudentRequest\RegisterToCoursesRequest;


class StudentController extends Controller
{

    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Display a list of students along with their associated courses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $students = $this->studentService->getAllStudentsWithCourses();
        return response()->json($students, 200);
    }

    /**
     * Display a specific student along with their courses.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

            $student = $this->studentService->getStudentById($id);
            return response()->json(new StudentResource($student), 200);


    }

    /**
     * Store a new student and associate them with courses.
     *
     * @param StoreStudentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreStudentRequest $request)
    {
        $student = $this->studentService->createStudent($request->validated(), $request->courses);
        return response()->json( new StudentResource($student), 201);
    }

    /**
     * Update an existing student and update their associated courses.
     *
     * @param UpdateStudentRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStudentRequest $request, $id)
    {

            $student = $this->studentService->updateStudent($id, $request->validated(), $request->courses);
            return response()->json(new StudentResource($student), 200);

    }

    /**
     * Delete a specific student and detach their courses.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

            $this->studentService->deleteStudent($id);
            return response()->json(['message' => 'Student deleted successfully!'], 200);
            
    }

    /**
     * Register a student to specific courses.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerToCourses(RegisterToCoursesRequest $request, $id)
    {

            $student = $this->studentService->registerToCourses($id, $request->courses);
            return response()->json(new StudentResource($student), 200);

    }

    /**
     * Get all students registered in a specific course.
     *
     * @param int $course_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentsInCourse($course_id)
    {

            $students = $this->studentService->getStudentsInCourse($course_id);
            return response()->json(StudentResource::collection($students), 200);

    }
}
