<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrackingHistory extends Model
{
    use HasFactory;

    protected $fillable = ['tracking_id', 'status', 'deskripsi', 'waktu'];

    public function tracking()
    {
        return $this->belongsTo(Tracking::class);
    }
}
