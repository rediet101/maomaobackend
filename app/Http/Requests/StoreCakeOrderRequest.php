<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCakeOrderRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'pickup_delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'delivery_type' => ['required', 'in:driver,self_pickup'],
            'delivery_address' => ['required_if:delivery_type,driver', 'nullable', 'string', 'max:500'],
            'flavour' => ['required', 'string', 'max:100'],
            'size' => ['required', 'string', 'max:100'],
            'design_inspiration' => ['nullable', 'string', 'max:500'],
            'additional_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
