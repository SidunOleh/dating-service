<?php

namespace App\Http\Resources\TransferRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransferRequestCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $transferRequest) {
            $data[$i]['id'] = $transferRequest->id;
            $data[$i]['amount'] = $transferRequest->amount;
            $data[$i]['creator'] = [
                'id' => $transferRequest->creator->id,
                'email' => $transferRequest->creator->email,
                'balance' => $transferRequest->creator->balance,
                'balance_2_total' => $transferRequest->creator->balance_2_total,
            ];
            $data[$i]['created_at'] = $transferRequest->created_at;
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
