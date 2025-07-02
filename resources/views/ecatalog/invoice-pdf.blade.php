<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        .no-border { border: none !important; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .big { font-size: 18px; font-weight: bold; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <!-- Header: Judul & Logo -->
    <table class="no-border" style="margin-bottom: 0;">
        <tr>
            <td class="no-border" style="vertical-align: middle;">
                <span class="big">Invoice Pembelian</span><br>
                <span style="font-size: 13px; color: #555;">Toko Usaha Muda Padang</span>
            </td>
            <td class="no-border text-right" style="vertical-align: middle;">
                <img src="{{ public_path('image/img_logo_tokousahamuda.png') }}" alt="Logo Usaha Muda" style="height: 100px;">
            </td>
        </tr>
    </table>

    <!-- Info Invoice & Penerima -->
    <table class="no-border" style="margin-bottom: 10px;">
        <tr>
            <td class="no-border" style="width: 60%;">
                <b>No. Pesanan:</b> {{ $order->order_number }}<br>
                <b>Tanggal:</b> {{ $order->created_at->format('d M Y') }}<br>
                <b>Status:</b> 
                @if($order->payment_status === 'paid' || $order->status === 'completed')
                    <span style="color: green; font-weight: bold;">LUNAS</span>
                @else
                    <span style="color: red; font-weight: bold;">BELUM LUNAS</span>
                @endif
            </td>
            <td class="no-border" style="width: 40%;">
                <b>Penerima:</b><br>
                {{ $order->user_name }}<br>
                {{ $order->alamat }}<br>
                Telp: {{ $order->telepon }}
            </td>
        </tr>
    </table>

    <!-- Tabel Produk -->
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Varian</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>
                    @if(!empty($item->variant_info) && is_array($item->variant_info))
                        @foreach($item->variant_info as $variant)
                            <div>
                                {{ ucfirst($variant['type'] ?? '') }}: {{ $variant['name'] ?? '' }}
                                @if(!empty($variant['additional_price']) && $variant['additional_price'] > 0)
                                    (+Rp {{ number_format($variant['additional_price'], 0, ',', '.') }})
                                @endif
                            </div>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right bold">Total</td>
                <td class="text-right bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer: Catatan & Stempel -->
    <div style="margin-top: 30px;">
        <div style="float: left; width: 60%;">
            <b>Catatan:</b><br>
            Terima kasih atas kepercayaan Anda berbelanja di Usaha Muda.<br>
            Untuk pertanyaan, hubungi: 08116655050
        </div>
        <div style="float: right; width: 40%; text-align: right;">
            @if($order->payment_status === 'paid' || $order->status === 'completed')
                <img src="{{ public_path('image/pngtree-paid-stamp-png-image_12439284.png') }}" alt="Lunas" style="height: 120px;">
            @endif
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html> 