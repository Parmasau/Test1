<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', 
        'price',
        'stock',
        'image',
    ];

    protected $attributes = [
        'stock' => 0,
        'image' => 'default-product.jpg',
    ];

    // Relationship with order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Check if product is in stock
    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }

    // Format price for display
    public function getFormattedPriceAttribute()
    {
        return 'Kshs ' . number_format($this->price, 0);
    }
}