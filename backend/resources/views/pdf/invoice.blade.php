<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
    .header { text-align: center; border-bottom: 2px solid #0F1F3D; padding-bottom: 16px; margin-bottom: 24px; }
    .header h1 { font-size: 24px; color: #0F1F3D; margin: 0; }
    .header p { color: #64748B; margin: 4px 0 0; }
    .invoice-meta { display: flex; justify-content: space-between; margin-bottom: 24px; }
    .badge { background: #0F1F3D; color: white; padding: 4px 12px; border-radius: 4px; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    th { background: #F1F5F9; padding: 8px 12px; text-align: left; font-size: 11px; text-transform: uppercase; }
    td { padding: 8px 12px; border-bottom: 1px solid #E2E8F0; }
    .total-row { font-weight: bold; font-size: 14px; background: #0F1F3D; color: white; }
    .payment-info { background: #FEF3C7; border: 1px solid #F59E0B; border-radius: 8px; padding: 16px; margin-top: 16px; }
    .footer { text-align: center; margin-top: 32px; color: #94A3B8; font-size: 11px; border-top: 1px solid #E2E8F0; padding-top: 12px; }
</style>
</head>
<body>
<div class="header">
    <h1>MAKLON.ID</h1>
    <p>Jasa Maklon Kosmetik Profesional</p>
    <p>invoice@maklon.id | +62 21 xxxx xxxx</p>
</div>

<div class="invoice-meta">
    <div>
        <strong>Kepada:</strong><br>
        {{ $order->user->name }}<br>
        {{ $order->user->profile?->company_name }}<br>
        {{ $order->user->email }}<br>
        {{ $order->user->phone }}
    </div>
    <div style="text-align: right;">
        <div class="badge">INVOICE</div><br><br>
        <strong>No. Invoice:</strong> {{ $invoice->invoice_number }}<br>
        <strong>Tanggal:</strong> {{ $invoice->created_at->format('d M Y') }}<br>
        <strong>Order:</strong> {{ $order->order_number }}<br>
        <strong>Jatuh Tempo:</strong> {{ $invoice->due_date?->format('d M Y') ?? '-' }}
    </div>
</div>

@if($invoice->subtotal_legal > 0)
<p><strong>A. BIAYA LEGALITAS (100%)</strong></p>
<table>
    <thead><tr><th>Item</th><th>Keterangan</th><th style="text-align:right">Jumlah</th></tr></thead>
    <tbody>
    @foreach($order->legalItems as $item)
    <tr>
        <td>{{ $item->label }}</td>
        <td>{{ $item->is_mandatory ? 'Wajib' : 'Opsional' }}</td>
        <td style="text-align:right">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
    </tr>
    @endforeach
    <tr style="font-weight:bold; background:#F8FAFC">
        <td colspan="2">Subtotal Legalitas</td>
        <td style="text-align:right">Rp {{ number_format($invoice->subtotal_legal, 0, ',', '.') }}</td>
    </tr>
    </tbody>
</table>
@endif

<p><strong>B. BIAYA PRODUK</strong></p>
<table>
    <thead><tr><th>Komponen</th><th>Detail</th><th style="text-align:right">Jumlah</th></tr></thead>
    <tbody>
    <tr><td>Base Formula</td><td>{{ $order->product?->name }} - {{ $order->quantity }} pcs</td><td style="text-align:right">—</td></tr>
    @foreach($order->orderMaterials as $om)
    <tr>
        <td>{{ $om->material->name }}</td>
        <td>{{ $om->dose_ml }}ml × {{ $order->quantity }} pcs @ Rp{{ number_format($om->price_per_ml,0,',','.') }}/ml</td>
        <td style="text-align:right">Rp {{ number_format($om->subtotal, 0, ',', '.') }}</td>
    </tr>
    @endforeach
    @if($invoice->subtotal_product > 0)
    <tr style="font-weight:bold; background:#F8FAFC">
        <td colspan="2">Subtotal Produk ({{ $invoice->type === 'dp' ? 'DP 50%' : 'Pelunasan 50%' }})</td>
        <td style="text-align:right">Rp {{ number_format($invoice->subtotal_product, 0, ',', '.') }}</td>
    </tr>
    @endif
    </tbody>
</table>

<table>
    <tbody>
    @if($invoice->subtotal_sample > 0)
    <tr><td><strong>Biaya Sample</strong></td><td style="text-align:right">Rp {{ number_format($invoice->subtotal_sample, 0, ',', '.') }}</td></tr>
    @endif
    <tr><td>PPN 11%</td><td style="text-align:right">Rp {{ number_format($invoice->ppn_amount, 0, ',', '.') }}</td></tr>
    <tr class="total-row"><td style="padding:12px">TOTAL YANG HARUS DIBAYAR</td><td style="text-align:right;padding:12px">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td></tr>
    </tbody>
</table>

<div class="payment-info">
    <strong>Informasi Pembayaran:</strong><br>
    Transfer ke: Bank BCA | No. Rek: 1234567890 | a.n. PT Maklon Indonesia<br>
    Wajib sertakan nomor order <strong>{{ $order->order_number }}</strong> pada keterangan transfer.<br>
    Setelah transfer, upload bukti di dashboard Anda.
</div>

<div class="footer">
    Invoice ini digenerate otomatis oleh sistem Maklon.id<br>
    Pertanyaan? Hubungi support@maklon.id
</div>
</body>
</html>
