<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Http\Resources\InstructorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,

            'students' => $this->whenLoaded('students', function () {
                return $this->students->pluck('name');
            }),
            // 'instructors'   => InstructorResource::collection($this->whenLoaded('instructors')),

             'instructors' => $this->whenLoaded('instructors', function () {
                return $this->instructors->pluck('name');
            }),
        ];
    }
}
