<div class="transaction-wrapper">
    <div class="transaction-popup">
        <div class="top">
            <div class="title">Transaction list: <span>(delay up to 1 hour)</span></div>
            <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        </div>
        <div class="transactions">
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Currency</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="transaction-item">
                            <td class="date">
                                {{ $transaction['date'] }}
                            </td>
                            <td class="type">
                                {{ $transaction['type'] }}
                            </td>
                            <td class="sum">
                                {{ $transaction['amount'] }}
                            </td>
                            <td class="currency">
                                {{ $transaction['currency'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>