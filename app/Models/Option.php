<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];

    public static function updateOrCreateSettings(array $settings): Collection
    {
        $collection = new Collection();
        foreach ($settings as $name => $value) {
            $collection->push(self::updateOrCreate(
                ['name' => $name,], ['value' => $value,]
            ));
        }
        
        return $collection;
    }

    public static function getSetting(string $name, $default = null)
    {
        $setting = self::where('name', $name)->first();

        return $setting ? $setting->value : $default;
    }
}
