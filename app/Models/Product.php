<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'satuan',
        'category_id',
        'stok',
        'foto'
    ];

    protected $casts = [
        'harga' => 'decimal:0'
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

    // Format harga dengan satuan
    public function getHargaFormatAttribute()
    {
        $formattedPrice = 'Rp ' . number_format($this->harga, 0, ',', '.');
        return $this->satuan 
            ? $formattedPrice . '/' . $this->satuan
            : $formattedPrice;
    }

    // Format harga dengan satuan untuk tampilan
    public function getDisplayPriceAttribute()
    {
        return $this->harga_format;
    }
}
