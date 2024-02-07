<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orderstatus;

class orderstatus extends Model
{
    protected $fillable = [
        'status',
        'status_order',
    ];
}
