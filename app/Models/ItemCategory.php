<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function stockPurchases()
    {
        return $this->hasMany(StockPurchase::class);
    }
}
