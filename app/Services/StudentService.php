<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\StudentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service class for handling student-related operations.
 */
class StudentService
{
     /**
     * Retrieve all students with their associated courses.

     * @throws \Exception
     */
    public function getAllStudentsWithCourses()
    {
        try {
            $students = Student::with('courses')->get();
            return (StudentResource::collection($students) );
        } catch (\Exception $e) {
            Log::error("Error fetching students with courses: " . $e->getMessage());
            throw $e;
        }
    }
     /**
     * Retrieve a specific student by ID along with their courses.
     *
     * @param int $id
     * @return \App\Models\Student
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function getStudentById($id)
    {
        try {
            $student = Student::with('courses')->findOrFail($id);
            return $student;
        } catch (ModelNotFoundException $e) {
            Log::error("Student not found with ID: $id. Error: " . $e->getMessage());
            throw $e;
        }
    }
    /**
     * Create a new student and associate them with courses.
     *
     * @param array $data
     * @param array $courses
     * @return \App\Models\Student
     * @throws \Exception
     */
    public function createStudent($validatedData, $courses)
    {
        try {
            $student = Student::create($validatedData);
            $student->courses()->sync($courses);
            $student->load('courses');
            return $student;
        } catch (\Exception $e) {
            Log::error("Error creating student: " . $e->getMessage());
            throw $e;
        }
    }
     /**
     * Update an existing student and manage their course associations.
     *
     * @param int $id
     * @param array $data
     * @param array $courses
     * @return \App\Models\Student
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function updateStudent($id, $validatedData, $courses)
    {
        try {
            $student = Student::findOrFail($id);
            $student->update($validatedData);
            $student->courses()->syncWithoutDetaching($courses);
            $student->load('courses');
            return  $student;
        } catch (ModelNotFoundException $e) {
            Log::error("Student not found with ID: $id. Error: " . $e->getMessage());
            throw $e;
        }
    }
     /**
     * Delete a student and detach them from all associated courses.
     *
     * @param int $id
     * @return void
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function deleteStudent($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->courses()->detach();
            $student->delete();
        } catch (ModelNotFoundException $e) {
            Log::error("Student not found with ID: $id. Error: " . $e->getMessage());
            throw $e;
        }
    }
     /**
     * Register a student to specific courses.
     *
     * @param int $id
     * @param array $courses
     * @return \App\Models\Student
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function registerToCourses($id, $courses)
    {
        try {
            $student = Student::findOrFail($id);
            $student->courses()->sync($courses);
            $student->load('courses');
            return  $student;
        } catch (ModelNotFoundException $e) {
            Log::error("Student not found with ID: $id. Error: " . $e->getMessage());
            throw $e;
        }
    }
       /**
     * Retrieve all students enrolled in a specific course.
     *
     * @param int $course_id
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function getStudentsInCourse($course_id)
    {
        try {
            $students = Course::findOrFail($course_id)->students;
            return  $students;
        } catch (ModelNotFoundException $e) {
            Log::error("Course not found with ID: $course_id. Error: " . $e->getMessage());
            throw $e;
        }
    }
}
