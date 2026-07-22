<?php

namespace App\Models;

use Database\Factories\MenuOrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'menu_item_id',
    'quantity',
    'name',
    'email',
    'phone',
    'pickup_delivery_date',
    'delivery_type',
    'delivery_address',
    'size',
    'allergies',
    'additional_notes',
    'total_price',
    'status',
    'rating',
    'feedback',
])]
class MenuOrder extends Model
{
    /** @use HasFactory<MenuOrderFactory> */
    use HasFactory;

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pickup_delivery_date' => 'date',
            'total_price' => 'decimal:2',
        ];
    }
}
