<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function priceHistory()
    {
        return $this->hasMany(PriceHistory::class);
    }
}
