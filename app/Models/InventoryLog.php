<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'description',
        'reference_type',
        'reference_id',
        'user_id'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'stock_before' => 'integer',
        'stock_after' => 'integer',
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke order (jika tipe out)
    public function order()
    {
        if ($this->reference_type === 'order') {
            return $this->belongsTo(Order::class, 'reference_id');
        }
        return null;
    }

    // Scope untuk barang masuk
    public function scopeIncoming($query)
    {
        return $query->where('type', 'in');
    }

    // Scope untuk barang keluar
    public function scopeOutgoing($query)
    {
        return $query->where('type', 'out');
    }

    // Get type label
    public function getTypeLabelAttribute()
    {
        return $this->type === 'in' ? 'Barang Masuk' : 'Barang Keluar';
    }

    // Get type color
    public function getTypeColorAttribute()
    {
        return $this->type === 'in' ? 'green' : 'red';
    }

    // Get formatted quantity
    public function getFormattedQuantityAttribute()
    {
        $prefix = $this->type === 'in' ? '+' : '-';
        return $prefix . number_format($this->quantity);
    }

    // Get reference description
    public function getReferenceDescriptionAttribute()
    {
        switch ($this->reference_type) {
            case 'order':
                return 'Penjualan';
            case 'purchase':
                return 'Pembelian';
            case 'adjustment':
                return 'Penyesuaian Stok';
            case 'return':
                return 'Retur';
            default:
                return 'Manual';
        }
    }

    // Static method untuk mencatat barang masuk
    public static function logIncoming($productId, $quantity, $description = null, $referenceType = null, $referenceId = null, $userId = null)
    {
        $product = Product::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $stockBefore = $product->stok;
        $stockAfter = $stockBefore + $quantity;

        // Update stok produk
        $product->update(['stok' => $stockAfter]);

        // Catat log
        return self::create([
            'product_id' => $productId,
            'type' => 'in',
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'user_id' => $userId
        ]);
    }

    // Static method untuk mencatat barang keluar
    public static function logOutgoing($productId, $quantity, $description = null, $referenceType = null, $referenceId = null, $userId = null)
    {
        $product = Product::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $stockBefore = $product->stok;
        $stockAfter = $stockBefore - $quantity;

        if ($stockAfter < 0) {
            throw new \Exception('Insufficient stock');
        }

        // Update stok produk
        $product->update(['stok' => $stockAfter]);

        // Catat log
        return self::create([
            'product_id' => $productId,
            'type' => 'out',
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'user_id' => $userId
        ]);
    }

    // Get summary untuk periode tertentu
    public static function getSummary($startDate = null, $endDate = null)
    {
        $query = self::with('product');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $incoming = $query->clone()->incoming()->sum('quantity');
        $outgoing = $query->clone()->outgoing()->sum('quantity');
        $netChange = $incoming - $outgoing;

        return [
            'incoming' => $incoming,
            'outgoing' => $outgoing,
            'net_change' => $netChange,
            'total_transactions' => $query->clone()->count()
        ];
    }
}
