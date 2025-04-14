<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use App\Services\Creators\CreatorsService;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function __construct(
        public CreatorsService $creatorsService
    )
    {
        
    }

    public function __invoke()
    {
        $creator = Auth::guard('web')->user();

        if (! $creator->profile_is_created) {
            return response(['message' => 'You don\'t have profile.'], 400);
        }

        $this->creatorsService->deleteProfile($creator);

        return response(['message' => 'OK',]);
    }
}
