<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'image',
        'quantity',
        'rate',
        'discount',
        'final_price',
        'status',
        // Add other fields from your sales table
    ];
    use HasFactory;
}