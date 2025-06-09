<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'description'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Format tampilan satuan (contoh: "/ Lusin" atau "/ Pcs")
    public function getDisplayAttribute()
    {
        return "/ " . $this->symbol;
    }
} 