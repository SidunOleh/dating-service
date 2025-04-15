<?php

namespace App\Http\Controllers\Admin\TransferRequests;

use App\Constants\Transactions;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferRequest\TransferRequestCollection;
use App\Models\TransferRequest;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('per_page', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');

        $transferRequests = TransferRequest::where([
            'status' => Transactions::TRANSFER_REQUEST_STATUS['pending'],
        ])->orderBy($orderby, $order)->paginate($perpage, ['*'], 'page', $page);

        return response(new TransferRequestCollection($transferRequests));
    }
}
