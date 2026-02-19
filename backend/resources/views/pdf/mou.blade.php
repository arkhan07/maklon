<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: 'Times New Roman', serif; font-size: 12px; color: #333; line-height: 1.8; }
    .header { text-align: center; margin-bottom: 24px; }
    .header h2 { font-size: 16px; text-transform: uppercase; text-decoration: underline; }
    h3 { font-size: 13px; margin-top: 20px; }
    table { width: 100%; border-collapse: collapse; margin: 12px 0; }
    td { padding: 6px 10px; vertical-align: top; }
    .ttd-section { display: flex; justify-content: space-between; margin-top: 40px; }
    .ttd-box { text-align: center; width: 45%; }
    .ttd-line { border-top: 1px solid #333; margin-top: 60px; padding-top: 4px; }
</style>
</head>
<body>
<div class="header">
    <h2>MAKLON.ID</h2>
    <h2>MEMORANDUM OF UNDERSTANDING (MOU)</h2>
    <p>No. MOU: {{ $order->order_number }}/MOU/{{ now()->year }}</p>
</div>

<p>Pada hari ini, <strong>{{ now()->format('d F Y') }}</strong>, telah disepakati Memorandum of Understanding antara:</p>

<h3>PIHAK PERTAMA (Maklon.id)</h3>
<table>
    <tr><td width="30%">Nama Perusahaan</td><td>: PT Maklon Indonesia</td></tr>
    <tr><td>Alamat</td><td>: Jakarta, Indonesia</td></tr>
    <tr><td>Sebagai</td><td>: Penyedia Jasa Maklon Kosmetik</td></tr>
</table>

<h3>PIHAK KEDUA (Customer)</h3>
<table>
    <tr><td width="30%">Nama</td><td>: {{ $user->name }}</td></tr>
    <tr><td>Perusahaan</td><td>: {{ $user->profile?->company_name ?? '-' }}</td></tr>
    <tr><td>Email</td><td>: {{ $user->email }}</td></tr>
    <tr><td>No. WA</td><td>: {{ $user->phone }}</td></tr>
</table>

<h3>SPESIFIKASI PRODUK</h3>
<table>
    <tr><td width="30%">Nomor Order</td><td>: {{ $order->order_number }}</td></tr>
    <tr><td>Produk</td><td>: {{ $order->product?->name ?? '-' }}</td></tr>
    <tr><td>Volume per Pcs</td><td>: {{ $order->volume_ml }} ml</td></tr>
    <tr><td>Jumlah Produksi</td><td>: {{ number_format($order->quantity) }} pcs</td></tr>
    <tr><td>Nama Brand</td><td>: {{ $order->brand_name }}</td></tr>
    <tr><td>Tipe Brand</td><td>: {{ $order->brand_type === 'haki' ? 'HAKI Sendiri' : 'Undername Brand' }}</td></tr>
</table>

<h3>SKEMA PEMBAYARAN</h3>
<table>
    <tr><td width="40%">Grand Total</td><td>: Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td></tr>
    <tr><td>Pembayaran Pertama (DP + Legalitas)</td><td>: Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</td></tr>
    <tr><td>Pelunasan (setelah produk jadi)</td><td>: Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}</td></tr>
</table>

<h3>KETENTUAN DAN SYARAT</h3>
<ol>
    <li>Pihak Kedua setuju untuk membayar DP sebesar 50% dari total biaya produk setelah MOU ini disetujui.</li>
    <li>Produksi dimulai setelah pembayaran DP dikonfirmasi oleh Pihak Pertama.</li>
    <li>Pelunasan 50% dilakukan setelah produk selesai diproduksi dan siap untuk dikirim.</li>
    <li>Biaya legalitas (BPOM, Halal, dll) dibayar 100% di awal dan tidak dapat dikembalikan.</li>
    <li>Revisi desain maksimal 2 (dua) kali untuk konsep yang sama.</li>
    <li>Estimasi waktu produksi sesuai dengan kapasitas produksi Pihak Pertama.</li>
    <li>Pembatalan order setelah DP dikonfirmasi dapat dikenakan biaya pembatalan.</li>
</ol>

<div class="ttd-section">
    <div class="ttd-box">
        <p>Pihak Pertama,<br>PT Maklon Indonesia</p>
        <div class="ttd-line">
            <strong>(_____________________)</strong><br>
            Direktur
        </div>
    </div>
    <div class="ttd-box">
        <p>Pihak Kedua,<br>{{ $user->profile?->company_name ?? $user->name }}</p>
        <div class="ttd-line">
            <strong>(_____________________)</strong><br>
            {{ $user->name }}<br>
            <small>*(Tanda tangan di atas materai Rp 10.000)*</small>
        </div>
    </div>
</div>
</body>
</html>
