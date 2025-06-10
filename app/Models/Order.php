<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Status Constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'order_number',
        'user_name',
        'email',
        'alamat',
        'telepon',
        'status',
        'payment_status',
        'total',
        'payment_proof',
        'cancel_reason',
        'cancelled_at'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Cek apakah pesanan masih bisa dibatalkan
     */
    public function canBeCancelled()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Relasi dengan user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan items pesanan
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate nomor order
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $prefix = 'ORD-' . date('Y') . date('m') . date('d') . '-';
                $unique = strtoupper(substr(uniqid(), -12));
                $order->order_number = $prefix . $unique;
            }
            $order->status = $order->status ?? self::STATUS_PENDING;
            $order->payment_status = $order->payment_status ?? 'unpaid';
        });
    }

    /**
     * Get all available statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled'
        ];
    }

    /**
     * Get the total price of the order.
     */
    public function getTotalAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Get the status label of the order.
     */
    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    /**
     * Get the status color class for the badge
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_PROCESSING => 'bg-blue-100 text-blue-800',
            self::STATUS_COMPLETED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
