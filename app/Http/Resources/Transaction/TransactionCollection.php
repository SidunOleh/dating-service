<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $transaction) {
            $data[$i]['id'] = $transaction->id;
            $data[$i]['gateway'] = $transaction->gateway;
            $data[$i]['type'] = $transaction->type;
            $data[$i]['usd_amount'] = $transaction->usd_amount;
            $data[$i]['status'] = $transaction->status;
            $data[$i]['creator'] = $transaction->creator ? [
                'id' => $transaction->creator->id,
                'email' => $transaction->creator->email,
            ] : null;
            $data[$i]['created_at'] = $transaction->created_at;
            $data[$i]['details'] = $transaction->details;
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
