<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Maklon.id — Platform Maklon Kosmetik Terpercaya</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#001f3d",
                        accent: "#10b981",
                    },
                    fontFamily: { sans: ["Inter", "sans-serif"] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .gradient-hero { background: linear-gradient(135deg, #001f3d 0%, #003366 60%, #004080 100%); }
        .feature-card:hover { transform: translateY(-4px); }
        .feature-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    </style>
</head>
<body class="bg-white font-sans">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-lg">factory</span>
                </div>
                <span class="text-primary font-bold text-lg tracking-tight">Maklon.id</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-primary hover:text-primary/70 transition-colors px-4 py-2 rounded-lg hover:bg-gray-50">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="text-sm font-semibold bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                    Daftar Gratis
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="gradient-hero pt-32 pb-24 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-white/10 text-white/90 rounded-full px-4 py-1.5 text-xs font-medium mb-6 border border-white/20">
                <span class="material-symbols-outlined text-sm text-accent">verified</span>
                Platform Maklon Kosmetik Terpercaya
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-5">
                Wujudkan Brand Kosmetik<br/>
                <span class="text-accent">Impian Anda</span> Bersama Kami
            </h1>
            <p class="text-white/70 text-lg max-w-2xl mx-auto mb-10">
                Layanan maklon kosmetik lengkap — dari formulasi, produksi, legalitas BPOM &amp; Halal,
                hingga kemasan siap jual. Mudah, terpercaya, transparan.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 bg-accent text-white font-bold px-8 py-3.5 rounded-xl hover:bg-accent/90 transition-all shadow-lg shadow-accent/30">
                    <span class="material-symbols-outlined text-xl">rocket_launch</span>
                    Mulai Sekarang — Gratis
                </a>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 bg-white/10 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/20 transition-all border border-white/20">
                    <span class="material-symbols-outlined text-xl">login</span>
                    Masuk ke Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="bg-gray-50 border-y border-gray-100 py-8 px-4">
        <div class="max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-2xl font-extrabold text-primary">500+</div>
                <div class="text-sm text-gray-500 mt-0.5">Brand Aktif</div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-primary">50+</div>
                <div class="text-sm text-gray-500 mt-0.5">Formula Tersedia</div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-primary">BPOM</div>
                <div class="text-sm text-gray-500 mt-0.5">Terdaftar &amp; Legal</div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-primary">Halal</div>
                <div class="text-sm text-gray-500 mt-0.5">Bersertifikat MUI</div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-20 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary mb-3">Semua yang Anda Butuhkan</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Dari ide hingga produk jadi, kami tangani semuanya dengan platform digital yang mudah digunakan.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @php
                $features = [
                    ['icon' => 'science', 'title' => 'Formulasi & Produksi', 'desc' => 'Pilih dari 50+ formula kosmetik atau kembangkan formula khusus sesuai kebutuhan brand Anda.'],
                    ['icon' => 'verified_user', 'title' => 'Legalitas BPOM & Halal', 'desc' => 'Kami bantu pengurusan izin BPOM, sertifikasi halal MUI, dan hak merek (HAKI) secara lengkap.'],
                    ['icon' => 'inventory_2', 'title' => 'Kemasan Siap Jual', 'desc' => 'Pilihan kemasan beragam dengan desain profesional — siap langsung dipasarkan ke konsumen.'],
                    ['icon' => 'description', 'title' => 'MOU Digital', 'desc' => 'Perjanjian kerjasama (MOU) digital yang transparan dan mudah ditandatangani secara online.'],
                    ['icon' => 'receipt_long', 'title' => 'Invoice & Pembayaran', 'desc' => 'Kelola invoice dan pembayaran secara terstruktur dengan riwayat transaksi yang lengkap.'],
                    ['icon' => 'local_shipping', 'title' => 'Tracking Produksi', 'desc' => 'Pantau status produksi order Anda secara real-time dari antri produksi hingga siap kirim.'],
                ];
                @endphp
                @foreach ($features as $f)
                <div class="feature-card bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <div class="w-10 h-10 bg-primary/5 rounded-xl flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary">{{ $f['icon'] }}</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="bg-gray-50 py-20 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary mb-3">Cara Kerja</h2>
                <p class="text-gray-500">Hanya 4 langkah mudah untuk memulai brand kosmetik Anda.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-6">
                @php
                $steps = [
                    ['num' => '1', 'icon' => 'how_to_reg', 'title' => 'Daftar & Verifikasi', 'desc' => 'Buat akun dan upload dokumen untuk verifikasi bisnis Anda.'],
                    ['num' => '2', 'icon' => 'edit_note', 'title' => 'Buat Order', 'desc' => 'Tentukan produk, formula, kemasan, dan kebutuhan legalitas.'],
                    ['num' => '3', 'icon' => 'handshake', 'title' => 'Tanda Tangani MOU', 'desc' => 'Setujui perjanjian kerjasama secara digital dan lakukan pembayaran.'],
                    ['num' => '4', 'icon' => 'inventory', 'title' => 'Terima Produk', 'desc' => 'Pantau produksi dan terima produk siap jual di tangan Anda.'],
                ];
                @endphp
                @foreach ($steps as $s)
                <div class="text-center">
                    <div class="w-14 h-14 bg-primary text-white rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-md">
                        <span class="material-symbols-outlined">{{ $s['icon'] }}</span>
                    </div>
                    <div class="text-xs font-bold text-accent uppercase tracking-widest mb-1">Langkah {{ $s['num'] }}</div>
                    <h3 class="font-semibold text-gray-900 mb-1.5 text-sm">{{ $s['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $s['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="gradient-hero py-20 px-4">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Siap Mulai Bisnis Kosmetik Anda?</h2>
            <p class="text-white/70 mb-8">Bergabunglah dengan ratusan brand yang sudah mempercayakan produksinya kepada kami.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 bg-accent text-white font-bold px-8 py-3.5 rounded-xl hover:bg-accent/90 transition-all">
                    <span class="material-symbols-outlined text-xl">rocket_launch</span>
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 bg-white/10 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/20 transition-all border border-white/20">
                    Sudah punya akun? Login
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary py-8 px-4">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-white/10 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-base">factory</span>
                </div>
                <span class="text-white font-bold">Maklon.id</span>
            </div>
            <p class="text-white/40 text-xs text-center">&copy; {{ date('Y') }} Maklon.id. Platform Maklon Kosmetik Terpercaya.</p>
            <div class="flex items-center gap-4 text-white/50 text-xs">
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a>
                <a href="{{ route('register') }}" class="hover:text-white transition-colors">Daftar</a>
            </div>
        </div>
    </footer>

</body>
</html>
