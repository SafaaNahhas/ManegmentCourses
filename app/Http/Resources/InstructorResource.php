<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CoursesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'experience' => $this->experience,
            'specialty' => $this->specialty,
            'courses' => $this->whenLoaded('courses', function () {
                return $this->courses->pluck('title');
            }),
        ];    }
}
