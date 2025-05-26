<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Isi kolom yang boleh diisi lewat mass assignment
    protected $fillable = [
        'user_id',    // id user jika login
        'user_name',  // nama user (guest)
        'email',
        'alamat',
        'telepon',
        'produk',     // nama produk yang dipesan (jika hanya 1 produk)
        'harga',      // harga produk
        'status',     // status pesanan, contoh: Diproses, Selesai, dll.
    ];

    /**
     * Relasi ke user (jika user login)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke order items (jika ada lebih dari 1 produk)
     * Pastikan tabel order_items dan model OrderItem tersedia jika pakai ini.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
