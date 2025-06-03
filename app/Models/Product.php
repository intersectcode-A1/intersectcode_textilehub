<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['nama', 'harga', 'stok', 'deskripsi', 'foto', 'category_id'];

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
}
