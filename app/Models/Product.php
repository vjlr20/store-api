<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "products";

    protected $fillable = array(
        'product_name',
        'description',
        'unit_price',
        'sale_price',
        'stock',
    );

    protected $hidden = array(
        'unit_price',
    );
}
