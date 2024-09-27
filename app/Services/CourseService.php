<?php
namespace App\Services;

use Exception;
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CoursesResource;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CourseService
{
      /**
     * Retrieve all courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCourses()
    {
        try {
            return Course::with(['instructors', 'students'])->get();
        } catch (Exception $e) {
            Log::error('Error fetching all courses: ' . $e->getMessage());
            throw $e; // Rethrow exception to be handled by the controller
        }
    }

    /**
     * Retrieve a specific course by ID.
     *
     * @param int $id
     * @return Course
     * @throws ModelNotFoundException
     */
    public function getCourseById($id)
    {
        try {
            return Course::with(['instructors', 'students'])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::warning("Course with ID {$id} not found.");
            throw $e;
        } catch (Exception $e) {
            Log::error("Error fetching course with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a new course.
     *
     * @param array $data
     * @return Course
     * @throws Exception
     */
    public function createCourse(array  $data)
    {
        try {
            $course = Course::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'start_date' => $data['start_date'],

            ]);

            // Sync instructors if provided
            if (isset($data['instructors'])) {
                $course->instructors()->sync($data['instructors']);
            }

            // Load instructors relationship
            $course->load('instructors');

            return $course;
        } catch (QueryException $e) {

            if ($e->getCode() === '23000' && strpos($e->getMessage(), 'courses_title_unique') !== false) {
                throw new Exception('عنوان الدورة مُستخدم بالفعل. يرجى اختيار عنوان آخر.');
            }
        } catch (Exception $e) {
            Log::error('Error creating course: ' . $e->getMessage());
            throw $e;  // Re-throw the exception to handle it in the controller
        }
    }
    /**
     * Update an existing course.
     *
     * @param int $id
     * @param array $data
     * @return Course
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function updateCourse($id, array $data)
    {
        try {
            $course = Course::findOrFail($id);
            $course->update($data);

            if (isset($data['instructors'])) {
                $course->instructors()->syncWithoutDetaching($data['instructors']);
            }

            $course->load('instructors');

            return $course;
        } catch (ModelNotFoundException $e) {
            Log::warning("Course with ID {$id} not found for update.");
            throw $e;
        } catch (Exception $e) {
            Log::error("Error updating course with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a course.
     *
     * @param int $id
     * @return void
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function deleteCourse($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->instructors()->detach();
            $course->students()->detach();
            $course->delete();
        } catch (ModelNotFoundException $e) {
            Log::warning("Course with ID {$id} not found for deletion.");
            throw $e;
        } catch (Exception $e) {
            Log::error("Error deleting course with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Attach an instructor to a course.
     *
     * @param int $courseId
     * @param int $instructorId
     * @return void
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function attachInstructor($courseId, $instructorId)
    {
        try {
            $course = Course::findOrFail($courseId);
            $course->instructors()->sync($instructorId);
        } catch (ModelNotFoundException $e) {
            Log::warning("Course with ID {$courseId} not found for attaching instructor.");
            throw $e;
        } catch (Exception $e) {
            Log::error("Error attaching instructor ID {$instructorId} to course ID {$courseId}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Attach a student to a course.
     *
     * @param int $courseId
     * @param int $studentId
     * @return void
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function attachStudent($courseId, $studentId)
    {
        try {
            $course = Course::findOrFail($courseId);
            $course->students()->sync($studentId);
        } catch (ModelNotFoundException $e) {
            Log::warning("Course with ID {$courseId} not found for attaching student.");
            throw $e;
        } catch (Exception $e) {
            Log::error("Error attaching student ID {$studentId} to course ID {$courseId}: " . $e->getMessage());
            throw $e;
        }
    }
}
