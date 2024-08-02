<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_category_id',
        'name',
        'serial_no',
        'gst_rate',
        'opening_stock',
        'current_stock',
        'wholesale_price',
        'retail_price',
        'image',
        'last_purchase_date',
        'last_sale_date',
        'created_by',
        'updated_by',
    ];

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function stockPurchases()
    {
        return $this->hasMany(StockPurchase::class);
    }
}
