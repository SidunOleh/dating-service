<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip',
        'city',
        'state',
        'latitude',
        'longitude',
    ];

    public $timestamps = false;
}
