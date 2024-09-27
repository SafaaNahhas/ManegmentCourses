<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CoursesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'name' => $this->name,
            'courses' => $this->whenLoaded('courses', function () {
                return $this->courses->pluck('title');
            }),
        ];
    }
}
