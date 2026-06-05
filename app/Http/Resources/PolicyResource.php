<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Policy API Resource
 *
 * @property int $id
 * @property int $customer_id
 * @property string|null $policy_number
 * @property string|null $plan_name
 * @property float|null $premium
 */
class PolicyResource extends JsonResource
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
            'policy_number' => $this->policy_number,
            'plan_name' => $this->plan_name,
            'premium' => $this->premium,
            'face_amount' => $this->face_amount,
            'effective_date' => $this->effective_date?->toDateString(),
            'expiration_date' => $this->expiration_date?->toDateString(),
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
