<?php

namespace App\Http\Resources\Warning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WarningCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $ad) {
            $data[$i]['id'] = $ad->id;
            $data[$i]['text'] = $ad->text;
            $data[$i]['link'] = $ad->link;
            $data[$i]['clicks_count'] = $ad->clicks_count;
        }

        $meta = [
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
        ];

        return [
            'data' => $data,
            'meta' => $meta,
        ];
    }
}
