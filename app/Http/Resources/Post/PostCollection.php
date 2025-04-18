<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $post) {
            $data[$i]['id'] = $post->id;
            $data[$i]['text'] = $post->text;
            $data[$i]['status'] = $post->status;
            $data[$i]['creator'] = [
                'id' => $post->creator->id,
                'email' => $post->creator->email,
            ];
            $data[$i]['created_at'] = $post->created_at;
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
