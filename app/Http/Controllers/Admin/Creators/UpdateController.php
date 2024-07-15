<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Events\CreatorInactivated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Creators\UpdateRequest;
use App\Models\Creator;
use App\Models\Image;

class UpdateController extends Controller
{
    public function __invoke(Creator $creator, UpdateRequest $request)
    {
        $validated = $request->validated();

        if ($validated['is_banned'] and ! $creator->is_banned) {
            CreatorInactivated::dispatch($creator);
        }

        $deletedPhotos = array_diff(
            $creator->photos ?? [],
            $validated['photos'] ?? []
        );
        Image::deleteByIds($deletedPhotos);

        $creator->update($validated);

        return response(['message' => 'OK',]);
    }
}
