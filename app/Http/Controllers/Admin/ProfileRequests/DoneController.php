<?php

namespace App\Http\Controllers\Admin\ProfileRequests;

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
        $data['user_id'] = Auth::id();

        $approved = $profileRequest->creator->is_approved;
        
        $profileRequest->update($data);
        $profileRequest->migrate();

        $nextProfileRequest = ProfileRequest::next($approved);

        return response(['next' => $nextProfileRequest?->id,]);
    }
}
