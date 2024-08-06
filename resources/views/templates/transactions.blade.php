<div class="transaction-wrapper">
    <div class="transaction-popup">
        <div class="top">
            <div class="title">Transaction list</div>
            <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        </div>
        <div class="transactions">
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Sum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr class="transaction-item">
                        <td class="date">
                            {{ $transaction->created_at->format('d.m.Y') }}
                        </td>
                        <td class="type">
                            {{ $transaction->type }}
                        </td>
                        <td class="status">
                            {{ $transaction->status }}
                        </td>
                        <td class="sum">
                            {{ $transaction->amount }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>