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
        'serial_name',
        'serial_no',
        'opening_stock',
        'wholesale_price',
        'retail_price'
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
