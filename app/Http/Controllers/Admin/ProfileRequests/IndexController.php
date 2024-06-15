<?php

namespace App\Http\Controllers\Admin\ProfileRequests;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $approved = $request->query('approved', true);
 
        $data = Creator::select(
            'creators.id AS creator_id',
            'creators.email AS creator_email', 
            'profile_requests.id', 
            'profile_requests.created_at'
        )->join('profile_requests', 'creators.id', '=', 'profile_requests.creator_id')
            ->where('creators.is_approved', $approved)
            ->where('profile_requests.status', 'undone')
            ->orderBy($orderby, $order)
            ->paginate($perpage, ['*'], 'page', $page);

        return response($data);
    }
}
