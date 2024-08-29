<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimensions extends Model
{
    protected $table = 'dimensions';

    protected $fillable = ['sku', 'weight', 'length', 'width', 'height'];
}
