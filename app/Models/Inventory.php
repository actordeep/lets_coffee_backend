<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
   

public function up()
{
    Schema::create('inventories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->integer('quantity');
        $table->string('unit');
        $table->decimal('price_per_unit', 8, 2);
        $table->timestamps();
    });
}

}
