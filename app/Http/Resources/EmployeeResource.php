<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'email' => $this->email,
            'department' => $this->department->name ?? null,
            'designation' => $this->detail->designation ?? null,
            'salary' => $this->detail->salary ?? null,
            'joined_date' => $this->detail->joined_date ?? null,
        ];
    }
}
