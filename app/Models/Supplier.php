<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'kontak', 'produk', 'harga_modal', 'deskripsi', 'satuan'];

    /**
     * Relasi dengan produk yang disupply
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get harga modal dalam format yang mudah dibaca
     */
    public function getHargaModalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_modal, 0, ',', '.');
    }

    /**
     * Get total nilai produk yang disupply
     */
    public function getTotalNilaiProdukAttribute()
    {
        return $this->products->sum(function($product) {
            return $product->harga * $product->stok;
        });
    }
}
