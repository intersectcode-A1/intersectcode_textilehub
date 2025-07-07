<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualInvoiceItem extends Model
{
    protected $fillable = ['manual_invoice_id', 'product_name', 'variant', 'quantity', 'price', 'subtotal'];

    public function invoice()
    {
        return $this->belongsTo(ManualInvoice::class, 'manual_invoice_id');
    }
}
