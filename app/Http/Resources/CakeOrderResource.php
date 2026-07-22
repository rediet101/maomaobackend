<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CakeOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'pickup_delivery_date' => $this->pickup_delivery_date ? $this->pickup_delivery_date->toISOString() : null,
            'flavour' => $this->flavour,
            'size' => $this->size,
            'design_inspiration' => $this->design_inspiration,
            'additional_notes' => $this->additional_notes,
            'price' => $this->price,
            'total_price' => $this->price, // Map price to total_price for frontend support
            'delivery_type' => $this->delivery_type,
            'delivery_address' => $this->delivery_address,
            'status' => $this->status ?? 'pending',
            'rating' => $this->rating ? (int) $this->rating : null,
            'feedback' => $this->feedback,
            'created_at' => $this->created_at ? $this->created_at->toISOString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toISOString() : null,
            'menu_item' => null, // Explicitly null for custom orders
        ];
    }
}
