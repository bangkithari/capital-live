<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Appointment API Resource
 *
 * @property int $id
 * @property int $customer_id
 * @property string|null $appointment_type
 * @property string|null $location
 */
class AppointmentResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'appointment_date' => $this->appointment_date?->toIso8601String(),
            'appointment_type' => $this->appointment_type,
            'location' => $this->location,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
