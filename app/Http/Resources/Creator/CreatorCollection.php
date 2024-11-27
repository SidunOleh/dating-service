<?php

namespace App\Http\Resources\Creator;

use App\Models\Creator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CreatorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $creator) {
            $data[$i]['id'] = $creator->id;
            $data[$i]['first_photo'] = $creator->gallery->first();
            $data[$i]['email'] = $creator->email;
            $data[$i]['name'] = $creator->name;
            $data[$i]['phone'] = $creator->phone;
            $data[$i]['age'] = $creator->age;
            $data[$i]['city'] = $creator->city;
            $data[$i]['created_at'] = $creator->created_at;
        }

        $totalCreators = Creator::count();
        $totalProfiles = Creator::where('profile_is_created', true)->count();

        $meta = [
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
            'total_creators' => $totalCreators,
            'total_profiles' => $totalProfiles,
        ];

        return [
            'data' => $data,
            'meta' => $meta,
        ];
    }
}
