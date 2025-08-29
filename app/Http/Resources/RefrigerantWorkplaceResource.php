<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RefrigerantWorkplaceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'business' => $this->business,
            'residence' => $this->residence,
            'vehicle_registration_number' => $this->vehicle_registration_number,
            'serial_number' => $this->serial_number,
            'machine_type' => $this->machine_type,
            'gas_type' => $this->gas_type,
            'initial_fill_amount' => $this->initial_fill_amount,
            'is_selected' => $this->is_selected,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
