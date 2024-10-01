<?php

namespace App\Http\Controllers\Admin\Creators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Creators\StoreRequest;
use App\Models\Creator;
use App\Models\ZipCode;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by_admin'] = true;

        $zip = ZipCode::firstWhere('zip', $validated['zip']);
        $validated['state'] = $zip->state;
        $validated['city'] = $zip->city;
        $validated['latitude'] = $zip->latitude;
        $validated['longitude'] = $zip->longitude;

        $creator = Creator::create($validated);

        return response(['id' => $creator->id,]);
    }
}
