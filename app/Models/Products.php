<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table="products";

    protected $fillable = [
        'item_number',
        'name_english',
        'name_sinhala',
        'visibility',
        'category',
        'unit_price',
        'mrp',
        'direct_sale_price',
        'img',
    ];
}
