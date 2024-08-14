<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'quantity',
        'amount',
        'purchase_transaction_date',
        'notes',
        'is_expense'
    ];

    public function CategoryPurchase()
    {
        return $this->belongsTo(CategoryPurchase::class, 'purchase_id', 'id');
    }
}
