<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Invoice Pembelian</h2>
    <p>No. Pesanan: <strong>{{ $order->order_number }}</strong></p>
    <p>Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
    <hr>
    <h4>Penerima:</h4>
    <p>{{ $order->user_name }}<br>
    {{ $order->alamat }}<br>
    Telp: {{ $order->telepon }}</p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="text-align:right;">
        <strong>Total: Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
    </div>
</body>
</html> 