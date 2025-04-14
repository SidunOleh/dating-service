<?php

namespace App\Http\Controllers\Admin\ProfileRequests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProdileRequests\DoneRequest;
use App\Models\ProfileRequest;
use App\Services\Creators\CreatorsService;
use Illuminate\Support\Facades\Auth;

class DoneController extends Controller
{
    public function __construct(
        public CreatorsService $creatorsService
    )
    {
        
    }

    public function __invoke(ProfileRequest $profileRequest, DoneRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'done';
        $data['user_id'] = Auth::guard('admin')->id();

        $nextProfileRequest = $this->creatorsService->doneProfileRequest($profileRequest, $data);

        return response(['next' => $nextProfileRequest?->id,]);
    }
}
