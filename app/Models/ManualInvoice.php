<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualInvoice extends Model
{
    protected $fillable = ['user_name', 'alamat', 'telepon', 'tanggal', 'total'];

    public function items()
    {
        return $this->hasMany(ManualInvoiceItem::class);
    }
}
