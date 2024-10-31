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

    public static function updateSettings(array $new)
    {
        $settings = json_decode(self::getOption('settings', '[]'), true);
        foreach ($new as $name => $value) {
            $settings[$name] = $value;
        }

        self::updateOrCreate(
            ['name' => 'settings',], 
            ['value' => json_encode($settings),]
        );
    }

    public static function getSettings(): array
    {
        $settings = json_decode(self::getOption('settings', '[]'), true);

        return [
            'show_top_warning' => 
                $settings['show_top_warning'] ?? false,
            'clicks_between_popups' => 
                $settings['clicks_between_popups'] ?? 10,
            'seconds_between_popups' => 
                $settings['seconds_between_popups'] ?? 60,
            'close_popup_seconds' =>
                 $settings['close_popup_seconds'] ?? 5,
            'referral_percent' => 
                $settings['referral_percent'] ?? 0,
            'repeat_time' => 
                $settings['repeat_time'] ?? 5,
            'subscription_price' => 
                $settings['subscription_price'] ?? 0,
        ];
    }

    public static function getContent(): array
    {
        $content = json_decode(self::getOption('content', '[]'), true);

        return $content;
    }
}
