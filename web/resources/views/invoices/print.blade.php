<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} - Maklon.id</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #1e293b; background: #f8fafc; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; min-height: 100vh; }
        .header { background: linear-gradient(135deg, #001f3d, #002952); color: #fff; padding: 40px 48px; }
        .header-inner { display: flex; justify-content: space-between; align-items: flex-start; }
        .logo-area h1 { font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }
        .logo-area p { font-size: 13px; opacity: 0.7; margin-top: 4px; }
        .invoice-meta { text-align: right; }
        .invoice-meta .inv-number { font-size: 20px; font-weight: 700; }
        .invoice-meta p { font-size: 12px; opacity: 0.75; margin-top: 4px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-top: 8px; }
        .badge-paid { background: #10b981; color: #fff; }
        .badge-pending { background: #f59e0b; color: #fff; }
        .badge-overdue { background: #ef4444; color: #fff; }
        .body { padding: 40px 48px; }
        .parties { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 32px; }
        .party-box { padding: 20px; border: 1px solid #e2e8f0; border-radius: 10px; }
        .party-box .label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; margin-bottom: 8px; }
        .party-box .name { font-size: 16px; font-weight: 700; color: #0f172a; }
        .party-box .detail { font-size: 13px; color: #64748b; margin-top: 4px; line-height: 1.6; }
        .section-title { font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .table th { background: #f1f5f9; padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #374151; }
        .table tr:last-child td { border-bottom: none; }
        .table .text-right { text-align: right; }
        .totals { margin-left: auto; width: 320px; margin-bottom: 32px; }
        .total-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 13px; border-bottom: 1px solid #f1f5f9; }
        .total-row.grand { padding: 12px 16px; background: #001f3d; color: #fff; border-radius: 8px; margin-top: 8px; font-weight: 700; font-size: 15px; border-bottom: none; }
        .payment-info { background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px; padding: 20px; margin-bottom: 32px; }
        .payment-info h4 { font-size: 13px; font-weight: 700; color: #166534; margin-bottom: 8px; }
        .payment-info p { font-size: 12px; color: #166534; line-height: 1.6; }
        .footer { border-top: 1px solid #e2e8f0; padding: 24px 48px; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; }
        .footer p { font-size: 11px; color: #94a3b8; }
        .print-btn { position: fixed; top: 20px; right: 20px; background: #001f3d; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(0,31,61,0.3); }
        .back-btn { position: fixed; top: 20px; right: 140px; background: #fff; color: #001f3d; border: 1px solid #cbd5e1; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        @media print {
            .print-btn, .back-btn { display: none; }
            body { background: #fff; }
            .container { box-shadow: none; }
        }
    </style>
</head>
<body>
    <a href="{{ url()->previous() }}" class="back-btn">← Kembali</a>
    <button onclick="window.print()" class="print-btn">🖨️ Cetak Invoice</button>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-inner">
                <div class="logo-area">
                    <h1>maklon.id</h1>
                    <p>Platform Maklon Kosmetik B2B</p>
                    <p style="margin-top:8px; font-size:12px;">Jl. Industri Kosmetik No. 1, Jakarta</p>
                    <p style="font-size:12px;">admin@maklon.id | +62 21 1234 5678</p>
                </div>
                <div class="invoice-meta">
                    <div class="inv-number">{{ $invoice->invoice_number }}</div>
                    <p>Tanggal: {{ $invoice->created_at->format('d M Y') }}</p>
                    <p>Jatuh Tempo: {{ $invoice->due_date?->format('d M Y') ?? '-' }}</p>
                    <div class="badge badge-{{ $invoice->status }}">{{ $invoice->statusLabel() }}</div>
                </div>
            </div>
        </div>

        <div class="body">
            <!-- Parties -->
            <div class="parties">
                <div class="party-box">
                    <div class="label">Dari</div>
                    <div class="name">PT Maklon Indonesia</div>
                    <div class="detail">
                        Jl. Industri Kosmetik No. 1<br>
                        Jakarta Timur 13220<br>
                        NPWP: 01.234.567.8-901.000
                    </div>
                </div>
                <div class="party-box">
                    <div class="label">Kepada</div>
                    <div class="name">{{ $invoice->user->name }}</div>
                    <div class="detail">
                        {{ $invoice->user->company_name ?? '-' }}<br>
                        {{ $invoice->user->email }}<br>
                        {{ $invoice->user->address ?? '' }}
                        @if($invoice->user->npwp)
                        <br>NPWP: {{ $invoice->user->npwp }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Info -->
            <div class="section-title">Detail Order</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = $invoice->order;
                        $productName = $order->product?->name ?? $order->product_name ?? 'Produk Custom';
                    @endphp
                    <tr>
                        <td>
                            <strong>Order #{{ $order->order_number }}</strong><br>
                            <span style="color:#64748b; font-size:12px;">
                                {{ $productName }}
                                @if($order->brand_name) — {{ $order->brand_name }}@endif
                                @if($order->quantity) ({{ number_format($order->quantity) }} pcs)@endif
                            </span>
                        </td>
                        <td class="text-right">—</td>
                    </tr>
                    @if($order->base_cost > 0)
                    <tr>
                        <td style="padding-left:32px; color:#64748b;">Biaya Produksi Dasar</td>
                        <td class="text-right">Rp {{ number_format($order->base_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($order->material_cost > 0)
                    <tr>
                        <td style="padding-left:32px; color:#64748b;">Biaya Bahan Baku</td>
                        <td class="text-right">Rp {{ number_format($order->material_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($order->packaging_cost > 0)
                    <tr>
                        <td style="padding-left:32px; color:#64748b;">Biaya Kemasan</td>
                        <td class="text-right">Rp {{ number_format($order->packaging_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($order->design_cost > 0)
                    <tr>
                        <td style="padding-left:32px; color:#64748b;">Biaya Desain</td>
                        <td class="text-right">Rp {{ number_format($order->design_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($order->sample_cost > 0)
                    <tr>
                        <td style="padding-left:32px; color:#64748b;">Biaya Sample</td>
                        <td class="text-right">Rp {{ number_format($order->sample_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($order->legal_cost > 0)
                    <tr>
                        <td style="padding-left:32px; color:#64748b;">Biaya Legalitas</td>
                        <td class="text-right">Rp {{ number_format($order->legal_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($order->ppn > 0)
                    <tr>
                        <td style="padding-left:32px; color:#64748b;">PPN 11%</td>
                        <td class="text-right">Rp {{ number_format($order->ppn, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Totals -->
            <div class="totals">
                @if($invoice->notes)
                <div class="total-row" style="font-style:italic; color:#64748b; font-size:12px; border-bottom:none; padding-bottom:4px;">
                    <span>{{ $invoice->notes }}</span>
                </div>
                @endif
                <div class="total-row grand">
                    <span>Total Invoice</span>
                    <span>{{ $invoice->formattedAmount() }}</span>
                </div>
                @if($invoice->paid_at)
                <div class="total-row" style="color:#10b981; font-weight:600; border-bottom:none;">
                    <span>✓ Dibayar pada</span>
                    <span>{{ $invoice->paid_at->format('d M Y') }}</span>
                </div>
                @endif
            </div>

            <!-- Payment History -->
            @if($invoice->payments && $invoice->payments->isNotEmpty())
            <div class="section-title">Riwayat Pembayaran</div>
            <table class="table" style="margin-bottom:32px;">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->payments as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $payment->methodLabel() }}</td>
                        <td>{{ $payment->statusLabel() }}</td>
                        <td class="text-right">{{ $payment->formattedAmount() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <!-- Payment Info -->
            <div class="payment-info">
                <h4>Informasi Rekening Pembayaran</h4>
                <p>
                    Bank BCA — No. Rekening: <strong>1234567890</strong> a.n. PT Maklon Indonesia<br>
                    Bank Mandiri — No. Rekening: <strong>0987654321</strong> a.n. PT Maklon Indonesia<br>
                    Mohon lampirkan bukti transfer dan nomor order saat melakukan pembayaran.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Dokumen ini digenerate otomatis oleh sistem maklon.id<br>Dicetak pada {{ now()->format('d M Y H:i') }}</p>
            <p style="text-align:right;">maklon.id &copy; {{ now()->year }}<br>Platform Maklon Kosmetik B2B Indonesia</p>
        </div>
    </div>
</body>
</html>
