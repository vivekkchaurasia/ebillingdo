<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_category_id',
        'item_id',
        'date',
        'quantity',      
        'created_by',
        'updated_by',
    ];

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
