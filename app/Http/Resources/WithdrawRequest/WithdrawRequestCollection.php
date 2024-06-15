<?php

namespace App\Http\Resources\WithdrawRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WithdrawRequestCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $transaction) {
            $data[$i]['id'] = $transaction->id;
            $data[$i]['gateway'] = $transaction->gateway;
            $data[$i]['usd_amount'] = $transaction->usd_amount;
            $data[$i]['status'] = $transaction->status;
            $data[$i]['concrete'] = $transaction->concrete;
            $data[$i]['creator']['id'] = $transaction->creator->id; 
            $data[$i]['creator']['email'] = $transaction->creator->email;
            $data[$i]['created_at'] = $transaction->created_at;
        }

        $meta = [
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
        ];

        return [
            'data' => $data,
            'meta' => $meta,
        ];
    }
}
