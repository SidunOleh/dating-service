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
                        <th>Amount</th>
                        <th>Currency</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        @if($transaction->gateway == 'plisio' and $transaction->type == 'invoice')
                            <tr class="transaction-item">
                                <td class="date">
                                    {{ $transaction->created_at->format('d.m.Y') }}
                                </td>
                                <td class="type">
                                    IN
                                </td>
                                <td class="status">
                                    {{ $transaction->status }}
                                </td>
                                <td class="sum">
                                    {{ $transaction->details->received }}
                                </td>
                                <td class="currency">
                                    {{ $transaction->details->currency }}
                                </td>
                            </tr>
                        @endif

                        @if($transaction->gateway == 'plisio' and $transaction->type == 'withdrawal')
                            <tr class="transaction-item">
                                <td class="date">
                                    {{ $transaction->created_at->format('d.m.Y') }}
                                </td>
                                <td class="type">
                                    OUT
                                </td>
                                <td class="status">
                                    {{ $transaction->status }}
                                </td>
                                <td class="sum">
                                    {{ $transaction->details->amount }}
                                </td>
                                <td class="currency">
                                    {{ $transaction->details->currency }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>