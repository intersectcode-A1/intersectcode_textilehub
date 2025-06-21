<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductVariant;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama', 
        'harga', 
        'stok', 
        'deskripsi', 
        'foto', 
        'category_id',
        'satuan',
        'unit_id'
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function priceHistory()
    {
        return $this->hasMany(PriceHistory::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
