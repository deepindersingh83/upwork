<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ref extends Model
{
    protected $table = 'ref';

    protected $fillable = ['sku', 'upc', 'ean', 'asin', 'barcode', 'brand_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
