<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'total_amount',
        // Add other fields from your sales table
    ];

    // Define relationships if any
}
