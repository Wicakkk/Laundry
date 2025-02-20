<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { width: 80px; }
        .header h2 { margin: 5px 0; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        .table th { background-color: #f4f4f4; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Transaction Report</h2>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Outlet</th>
                <th>Deadline</th>
                <th>Total Payment</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSemua = 0; @endphp
            @foreach ($transaksis as $index => $transaksi)
                @php
                    $subtotal = $transaksi->details->sum(fn($d) => $d->paket->harga * $d->qty);
                    $diskon = $subtotal * ($transaksi->diskon / 100);
                    $total = $subtotal - $diskon + $transaksi->pajak + $transaksi->biaya_tambahan;
                    $totalSemua += $total;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaksi->kode_invoice }}</td>
                    <td>{{ $transaksi->member->nama }}</td>
                    <td>{{ $transaksi->outlet->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->batas_waktu)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Grand Total</th>
                <th>Rp {{ number_format($totalSemua, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Generated on: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

</body>
</html>
