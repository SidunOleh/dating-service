<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Events\CreatorInactivated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Creators\UpdateRequest;
use App\Models\Creator;

class UpdateController extends Controller
{
    public function __invoke(Creator $creator, UpdateRequest $request)
    {
        $validated = $request->validated();

        $ban = $validated['is_banned'] and ! $creator->is_banned;

        // $creator->update($validated);
        
        $creator->updateProfileAndCreateRequest($validated);

        if ($ban) {
            CreatorInactivated::dispatch($creator);
        }

        return response(['message' => 'OK',]);
    }
}
