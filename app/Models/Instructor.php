<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Student;
use App\Models\CourseStudent;
use App\Models\CourseInstructor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instructor extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'experience',
        'specialty',
    ];
    /**
     * The courses that belong to the instructors
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_instructor')
            ;
    }

     /**
     * The students associated with the instructor through courses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function students()
{
    return $this->hasManyThrough(
        CourseStudent::class,
        CourseInstructor::class,
        'instructor_id',
        'course_id',
        'id',
        'course_id'
    );
}

}
