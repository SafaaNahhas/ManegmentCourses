<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
    ];
    /**
     * The instructors that belong to the courses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function instructors(): BelongsToMany
    {
        return $this->belongsToMany(Instructor::class, 'course_instructor')
            ;
    }
    /**
     * The Students that belong to the courses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_student');
    }

    protected static function boot()
    {
      parent::boot();

      static::deleting(function ($course) {
          $course->students()->detach();

          $course->instructors()->detach();
        });
    }
}
