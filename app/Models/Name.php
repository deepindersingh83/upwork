<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Name extends Model
{
    protected $table = 'name';

    protected $fillable = [
        'sku',
        'ls_name',
        'alloy_name',
        'mmt_name',
        'ds_name',
        'dd_name',
        'synnex_name'
    ];

    public function description(): HasOne
    {
        return $this->hasOne(Description::class, 'sku', 'sku');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'sku', 'sku');
    }
}
