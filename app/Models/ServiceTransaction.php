<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'quantity',
        'amount',
        'service_transaction_date',
        'notes',
        'is_income'
    ];

    public function CategoryService()
    {
        return $this->belongsTo(CategoryService::class, 'service_id', 'id');
    }
}
