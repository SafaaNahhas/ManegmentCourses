<?php

namespace App\Services;

use App\Models\Instructor;
use App\Http\Resources\CoursesResource;
use App\Http\Resources\InstructorResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class InstructorService
{
    /**
     * Create a new instructor with associated courses.
     *
     * @param array $data
     */
    public function createInstructor(array $data)
    {
        try {
            $instructor = Instructor::create($data);
            $instructor->courses()->sync($data['courses']);  // Sync courses
            $instructor->load('courses');

            return $instructor;
        } catch (\Exception $e) {
            Log::error('Error creating instructor: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Show a specific instructor and their associated courses.
     *
     * @param int $id
     */
    public function showInstructor(int $id)
    {
        try {
            $instructor = Instructor::with('courses')->findOrFail($id);
            // if(! $instructor){return "Instructor not found";}
            return $instructor;
        } catch (ModelNotFoundException $e) {
            Log::error("Instructor not found: ID {$id}");
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error retrieving instructor: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get a list of all instructors with their associated courses.
     *
     */
    public function getAllInstructors()
    {
        try {
            $instructors = Instructor::with('courses')->get();
            return $instructors;
        } catch (\Exception $e) {
            Log::error('Error retrieving instructors: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update the specified instructor and their courses.
     *
     * @param array $data
     * @param int $id
     */
    public function updateInstructor(array $data, int $id)
    {
        try {
            $instructor = Instructor::findOrFail($id);
            $instructor->update($data);
            $instructor->courses()->syncWithoutDetaching($data['courses']);
            $instructor->load('courses');

            return $instructor;
        } catch (ModelNotFoundException $e) {
            Log::error("Instructor not found for update: ID {$id}");
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating instructor: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete the specified instructor and detach their courses.
     *
     * @param int $id
     */
    public function deleteInstructor(int $id)
    {
        try {
            $instructor = Instructor::findOrFail($id);
            $instructor->courses()->detach();
            $instructor->delete();

            return $instructor;
        } catch (ModelNotFoundException $e) {
            Log::error("Instructor not found for deletion: ID {$id}");
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error deleting instructor: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get courses associated with a specific instructor.
     *
     * @param int $instructor_id
     */
    public function getCoursesByInstructor(int $instructor_id)
    {
        try {
            $courses = Instructor::findOrFail($instructor_id)->courses;
            return $courses;
        } catch (ModelNotFoundException $e) {
            Log::error("Courses not found for instructor: ID {$instructor_id}");
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error retrieving courses by instructor: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get students associated with a specific instructor via their courses.
     *
     * @param int $instructor_id
     */
    public function getStudentsByInstructor(int $instructor_id)
    {
        try {
            $students = Instructor::findOrFail($instructor_id)->students;
            return $students;
        } catch (ModelNotFoundException $e) {
            Log::error("Students not found for instructor: ID {$instructor_id}");
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error retrieving students by instructor: ' . $e->getMessage());
            throw $e;
        }
    }
}
