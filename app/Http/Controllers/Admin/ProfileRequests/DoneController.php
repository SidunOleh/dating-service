<?php

namespace App\Http\Controllers\Admin\ProfileRequests;

use App\Events\ProfileApproved;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProdileRequests\DoneRequest;
use App\Models\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class DoneController extends Controller
{
    public function __invoke(ProfileRequest $profileRequest, DoneRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'done';
        $data['user_id'] = Auth::guard('admin')->id();

        $approved = $profileRequest->creator->is_approved;
        
        $profileRequest->update($data);
        $profileRequest->migrateDataToProfile();

        if ($profileRequest->creator->is_approved) {
            ProfileApproved::dispatch($profileRequest->creator);
        }

        $profileRequest->creator->secondLastProfileRequest()?->deleteRejectedPhotos();

        $nextProfileRequest = ProfileRequest::next($approved);

        return response(['next' => $nextProfileRequest?->id,]);
    }
}
