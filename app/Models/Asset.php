<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [

        'serial_number',
        'description',
        'fix_or_movable',
        'picture_path',
        'purchase_date',
        'start_use_date',
        'purchase_price', 
        'serial_number',
        'warranty_expire_date',
        'degradation_in_years',
        'current_value_in_naira',
        'location'
    ];
}
