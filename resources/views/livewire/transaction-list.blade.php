<div>

    <div class="card p-4 shadow-sm mb-4" style="border-radius:15px;">
        <h4 class="mb-0">📊 Data Transaksi</h4>
        <small class="text-muted">Riwayat penjualan</small>
    </div>

    <div class="card p-3 shadow-sm" style="border-radius:15px;">

        <table class="table align-middle">

            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Meja</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th colspan="2" >Tanggal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $trx)
                <tr wire:click="toggleDetail({{ $trx->id }})"
                    class="{{ $openId === $trx->id ? 'table-primary' : '' }}"
                    style="cursor:pointer; transition:0.2s;">
                    <td><strong>{{ $trx->invoice }}</strong></td>

                    <td>
                        {{ optional($trx->table)->name ?? '-' }}
                    </td>

                    <td>
                        {{ optional($trx->user)->name ?? '-' }}
                    </td>

                    <td>
                        Rp {{ number_format($trx->total) }}
                    </td>

                    <td>
                        @if($trx->status == 'pending')
                            <span class="badge bg-danger">Pending</span>
                        @elseif($trx->status == 'cooking')
                            <span class="badge bg-warning text-dark">Cooking</span>
                        @else
                            <span class="badge bg-success">Done</span>
                        @endif
                    </td>

                    <td>
                        {{ $trx->created_at->format('d M Y H:i') }}
                    </td>
                    <td>
                        {{ $openId === $trx->id ? '⬆️' : '⬇️' }}
                    </td>
                </tr>
                @if($openId === $trx->id)
                <tr>
                    <td colspan="7">

                        <div class="bg-light p-3 rounded shadow-sm">

                            @foreach($trx->details as $item)
                                <div class="d-flex justify-content-between">
                                    <span>
                                        {{ $item->name }} ({{ $item->qty }})
                                    </span>
                                    <span>
                                        Rp {{ number_format($item->subtotal) }}
                                    </span>
                                </div>
                            @endforeach

                        </div>

                    </td>
                </tr>
                @endif
                


                @endforeach
            </tbody>

        </table>

    </div>

</div>
