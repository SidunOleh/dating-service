<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\StoreRequest;
use App\Models\ZipCode;
use App\Services\Creators\CreatorsService;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __construct(
        public CreatorsService $creatorsService
    )
    {
        
    }

    public function __invoke(StoreRequest $requets)
    {
        $creator = Auth::guard('web')->user();

        if ($creator->profile_is_created) {
            return response(['message' => 'You have profile.'], 400);
        }

        $validated = $requets->validated();

        $zip = ZipCode::firstWhere('zip', $validated['zip']);
        $validated['state'] = $zip->state;
        $validated['city'] = $zip->city;
        $validated['latitude'] = $zip->latitude;
        $validated['longitude'] = $zip->longitude;

        $this->creatorsService->createProfileRequest($creator, $validated);

        return response(['message' => 'OK',]);
    }
}
