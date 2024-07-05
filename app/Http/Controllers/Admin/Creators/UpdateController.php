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

        $ban = $validated['is_banned'] and ! $creator->is_banned;

        $imgsToDelete = array_diff(
            $creator->photos ?? [],
            $validated['photos'] ?? []
        );

        // $creator->update($validated);

        $creator->createProfileRequest($validated);

        Image::deleteByIds($imgsToDelete);
        
        if ($ban) {
            CreatorInactivated::dispatch($creator);
        }

        return response(['message' => 'OK',]);
    }
}
