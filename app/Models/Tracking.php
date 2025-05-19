<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = ['resi', 'nama_penerima', 'status'];

    public function histories()
    {
        return $this->hasMany(TrackingHistory::class);
    }
}
