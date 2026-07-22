<?php

namespace App\Models;

use Database\Factories\CakeOrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'email',
    'phone',
    'pickup_delivery_date',
    'price',
    'delivery_type',
    'delivery_address',
    'flavour',
    'size',
    'design_inspiration',
    'additional_notes',
    'status',
    'rating',
    'feedback',
])]
class CakeOrder extends Model
{
    /** @use HasFactory<CakeOrderFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pickup_delivery_date' => 'date',
            'price' => 'decimal:2',
        ];
    }
}
