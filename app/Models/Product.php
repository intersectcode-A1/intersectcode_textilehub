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
        'supplier_id',
        'satuan',
        'unit_id'
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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

    // Relasi ke inventory logs
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    // Get incoming logs
    public function incomingLogs()
    {
        return $this->hasMany(InventoryLog::class)->where('type', 'in');
    }

    // Get outgoing logs
    public function outgoingLogs()
    {
        return $this->hasMany(InventoryLog::class)->where('type', 'out');
    }

    /**
     * Get harga modal dari supplier atau estimasi
     */
    public function getHargaModalAttribute()
    {
        if ($this->supplier && $this->supplier->harga_modal) {
            return $this->supplier->harga_modal;
        }
        
        // Estimasi 70% dari harga jual jika tidak ada harga modal
        return $this->harga * 0.7;
    }

    /**
     * Get margin profit
     */
    public function getMarginProfitAttribute()
    {
        if ($this->harga > 0) {
            return (($this->harga - $this->harga_modal) / $this->harga) * 100;
        }
        return 0;
    }
}
