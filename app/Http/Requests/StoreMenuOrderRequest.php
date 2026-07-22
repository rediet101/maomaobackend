<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'menu_item_id' => ['required', 'integer', 'exists:menu_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'pickup_delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'delivery_type' => ['required', 'in:driver,self_pickup'],
            'delivery_address' => ['required_if:delivery_type,driver', 'nullable', 'string', 'max:500'],
            'size' => ['required', 'string', 'max:100'],
            'allergies' => ['nullable', 'string', 'max:255'],
            'additional_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
