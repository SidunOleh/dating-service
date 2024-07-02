<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $setting) {
            if ($setting->name == 'show_top_ad') {
                $data[$setting->name] = (bool) $setting->value;
            } else {
                $data[$setting->name] = $setting->value;
            }
        }

        return $data;
    }
}
