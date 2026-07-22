<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuOrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'menu_item' => new MenuItemResource($this->whenLoaded('menuItem')),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'pickup_delivery_date' => $this->pickup_delivery_date->toDateString(),
            'delivery_type' => $this->delivery_type,
            'delivery_type_label' => $this->delivery_type === 'driver' ? 'Driver Delivery' : 'Self Pickup',
            'delivery_address' => $this->delivery_type === 'driver'
                ? $this->delivery_address
                : 'Bole Welo Sefer, Addis Ababa, Ethiopia',
            'size' => $this->size,
            'allergies' => $this->allergies,
            'additional_notes' => $this->additional_notes,
            'quantity' => (int) $this->quantity,
            'unit_price' => $this->whenLoaded('menuItem', fn () => number_format((float) $this->menuItem->price, 2)),
            'total_price' => number_format((float) $this->total_price, 2),
            'status' => $this->status ?? 'pending',
            'rating' => $this->rating ? (int) $this->rating : null,
            'feedback' => $this->feedback,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
