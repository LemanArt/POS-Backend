<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .column-no {
            width: 30px;
            text-align: center;
        }

        .column-total-item {
            width: 80px;
            text-align: center;
        }

        .no-bullet {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h2>Laporan Penjualan</h2>
    <h4>Periode: {{ request('start_date') }} s/d {{ request('end_date') }}</h4>
    <br>

    <table>
        <thead>
            <tr>
                <th class="column-no">No</th>
                <th>Produk</th>
                <th class="column-total-item">Total Item</th>
                <th>Total Harga</th>
                <th>Kasir</th>
                <th>Waktu Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; $lastCashier = null; $no = 1; @endphp
            @forelse ($orders as $order)
                <tr>
                    <td class="column-no">{{ $no++ }}</td>
                    <td>
                        <ul class="no-bullet">
                            @foreach ($order->orderItems as $item)
                                <li>
                                    <strong>{{ $item->product->name ?? '-' }}</strong><br>
                                    {{ $item->quantity }} x Rp
                                    {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="column-total-item">{{ $order->total_item }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>{{ $order->kasir->name ?? 'N/A' }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($order->transaction_time)->format('d-m-Y') }}
                        - {{ \Carbon\Carbon::parse($order->transaction_time)->format('H:i') }}
                    </td>
                </tr>
                @php
                    $grandTotal += $order->total_price;
                    $lastCashier = $order->kasir->name ?? 'N/A';
                @endphp
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-center">Total Keseluruhan</th>
                <th colspan="3">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <br><br>
    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y H:i') }}<br><br>
        Oleh: {{ auth()->user()->name ?? 'N/A' }}
    </div>

</body>

</html>
