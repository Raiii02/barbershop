<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
    ];
}
