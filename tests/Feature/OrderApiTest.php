<?php

use App\Models\CakeOrder;
use App\Models\MenuOrder;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('api returns both cake orders and menu orders', function () {
    $menuItem = MenuItem::factory()->create([
        'title' => 'Test Item',
        'description' => 'Test Description',
        'price' => 1500,
    ]);
    
    // Create a custom cake order
    CakeOrder::factory()->create([
        'name' => 'Rediet',
        'email' => 'rediet@gmail.com',
        'phone' => '0911223344',
        'pickup_delivery_date' => '2026-07-23',
        'flavour' => 'Chocolate',
        'size' => '8 inch (10–12 pax)',
        'delivery_type' => 'driver',
        'price' => 5000,
    ]);

    // Create a menu order
    MenuOrder::factory()->create([
        'menu_item_id' => $menuItem->id,
        'name' => 'John Doe',
        'email' => 'john@gmail.com',
        'phone' => '0911223344',
        'pickup_delivery_date' => '2026-07-23',
        'size' => 'large',
        'delivery_type' => 'self_pickup',
        'total_price' => 1500,
        'quantity' => 1,
    ]);

    $response = $this->getJson('/api/orders');

    $response->assertStatus(200)
        ->assertJsonCount(2, 'data');

    // Assert custom cake order mappings
    $response->assertJsonFragment([
        'order_type' => 'custom',
        'price' => '5000.00',
        'total_price' => '5000.00',
    ]);

    // Assert menu order mappings
    $response->assertJsonFragment([
        'order_type' => 'menu',
        'total_price' => '1,500.00',
    ]);
});

test('api filters orders by phone number', function () {
    $menuItem = MenuItem::factory()->create([
        'title' => 'Test Item 2',
        'description' => 'Test Description 2',
        'price' => 1000,
    ]);
    
    // Create orders for phone A
    CakeOrder::factory()->create([
        'name' => 'Rediet',
        'email' => 'rediet@gmail.com',
        'phone' => '0911111111',
        'pickup_delivery_date' => '2026-07-23',
        'flavour' => 'Chocolate',
        'size' => '8 inch (10–12 pax)',
        'delivery_type' => 'driver',
        'price' => 5000,
    ]);

    MenuOrder::factory()->create([
        'menu_item_id' => $menuItem->id,
        'name' => 'John Doe',
        'email' => 'john@gmail.com',
        'phone' => '0911111111',
        'pickup_delivery_date' => '2026-07-23',
        'size' => 'large',
        'delivery_type' => 'self_pickup',
        'total_price' => 1000,
        'quantity' => 1,
    ]);

    // Create order for phone B
    CakeOrder::factory()->create([
        'name' => 'Riley',
        'email' => 'riley@gmail.com',
        'phone' => '0922222222',
        'pickup_delivery_date' => '2026-07-23',
        'flavour' => 'Vanilla',
        'size' => '6 inch',
        'delivery_type' => 'self_pickup',
        'price' => 3000,
    ]);

    $response = $this->getJson('/api/orders?phone=0911111111');

    $response->assertStatus(200)
        ->assertJsonCount(2, 'data');

    $response->assertJsonMissing([
        'phone' => '0922222222'
    ]);
});
