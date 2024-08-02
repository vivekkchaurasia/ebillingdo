<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_address',
        'gst_no',
        'email',
        'price_type',
        'invoice_date',
        'grand_total',
        'total_tax',
        'created_by',
        'updated_by',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
