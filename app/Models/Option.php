<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];

    public static function getOption(string $name, $default = null)
    {
        $option = self::where('name', $name)->first();

        return $option ? $option->value : $default;
    }
}
