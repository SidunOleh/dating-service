<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Creators\StoreRequest;
use App\Models\Creator;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by_admin'] = true;

        // $creator = Creator::create($validated);

        $creator = Creator::create(
            $request->only(['email', 'password',])
        );
        $creator->updateAndCreateProfileRequest($validated);

        return response(['id' => $creator->id,]);
    }
}
