<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'stock';

    // Specify the fillable fields
    protected $fillable = [
        'sku',
        'ls_stock',
        'ls_cp',
        'alloy_stock',
        'alloy_cp',
        'mmt_stock',
        'mmt_cp',
        'ds_stock',
        'ds_cp',
        'dd_stock',
        'dd_cp',
        'rrp',
    ];
}
