<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'nama', 
        'harga', 
        'stok', 
        'deskripsi', 
        'foto', 
        'category_id',
        'satuan'
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke varian produk
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
