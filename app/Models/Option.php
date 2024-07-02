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

    public static function updateOrCreateOptions(array $settings): Collection
    {
        $collection = new Collection();
        foreach ($settings as $name => $value) {
            $option = self::updateOrCreate(
                ['name' => $name,], ['value' => $value,]
            );

            $collection->push($option);
        }
        
        return $collection;
    }

    public static function getOption(string $name, $default = null)
    {
        $setting = self::where('name', $name)->first();

        return $setting ? $setting->value : $default;
    }

    public static function getOptions(array $names): Collection
    {
       return self::whereIn('name', $names)->get();
    }
}
