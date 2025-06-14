<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'variant_info'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'variant_info' => 'json'
    ];

    /**
     * Relasi dengan order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi dengan produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get subtotal
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
