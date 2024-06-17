<?php

namespace App\Http\Resources\Ad;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdCollection extends ResourceCollection
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
            $data[$i]['name'] = $ad->name;
            $data[$i]['link'] = $ad->link;
            $data[$i]['image_id'] = $ad->image_id;
            $data[$i]['image_url'] = $ad->image->url();
            $data[$i]['clicks_limit'] = $ad->clicks_limit;
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
