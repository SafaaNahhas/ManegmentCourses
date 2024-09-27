<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CoursesResource;
use App\Http\Resources\StudentResource;
use App\Http\Requests\CourseReqest\StoreCourseRequest;
use App\Http\Requests\CourseReqest\UpdateCourseRequest;
use App\Http\Requests\CourseReqest\AttachStudentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\CourseReqest\AttachInstructorRequest;


class CourseController extends Controller
{

     /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * CourseController constructor.
     *
     * @param CourseService $courseService
     */
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of courses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {

            $courses = $this->courseService->getAllCourses();
            return response()->json(CoursesResource::collection($courses), 200);

    }

    /**
     * Display the specified course with instructors and students.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {

            $course = $this->courseService->getCourseById($id);
            return response()->json(new CoursesResource($course), 200);

    }

    /**
     * Store a newly created course in storage.
     *
     * @param StoreCourseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCourseRequest $request): JsonResponse
    {
            $course = $this->courseService->createCourse($request->validated());
            return response()->json(new CoursesResource($course), 201);

    }

    /**
     * Update the specified course in storage.
     *
     * @param UpdateCourseRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCourseRequest $request, $id): JsonResponse
    {

            $course = $this->courseService->updateCourse($id, $request->validated());
            return response()->json(new CoursesResource($course), 200);

    }

    /**
     * Remove the specified course from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {

            $this->courseService->deleteCourse($id);
            return response()->json(['message' => 'Course deleted successfully!'], 200);

    }

    /**
     * Attach an instructor to a course.
     *
     * @param AttachInstructorRequest $request
     * @param int $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachInstructorToCourse(AttachInstructorRequest $request, $courseId): JsonResponse
    {

            $this->courseService->attachInstructor($courseId, $request->instructor_id);
            return response()->json(['message' => 'Instructor attached successfully to the course.'], 200);

    }

    /**
     * Attach a student to a course.
     *
     * @param AttachStudentRequest $request
     * @param int $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachStudentToCourse(AttachStudentRequest $request, $courseId): JsonResponse
    {

            $this->courseService->attachStudent($courseId, $request->student_id);
            return response()->json(['message' => 'Student attached successfully to the course.'], 200);

    }
}
