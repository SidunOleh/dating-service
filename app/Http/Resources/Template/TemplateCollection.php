<?php

namespace App\Http\Resources\Template;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TemplateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $listTemplate) {
            $data[$i]['id'] = $listTemplate->id;
            $data[$i]['template'] = $listTemplate->template;
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
