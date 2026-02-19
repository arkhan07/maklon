# Maklon.id — Laravel REST API Backend

Backend REST API untuk platform jasa maklon kosmetik **Maklon.id**, dibangun dengan Laravel 11.

---

## Stack Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 11 |
| Auth | Laravel Sanctum (token-based) |
| Social Auth | Laravel Socialite (Google OAuth) |
| PDF | DomPDF (invoice & MOU) |
| Database | MySQL / SQLite (dev) |
| PHP | 8.2+ |

---

## Struktur Direktori

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   ├── Auth/           # AuthController, GoogleAuthController
│   │   ├── Customer/       # Dashboard, Order, Invoice, Payment, MOU, Tracking, Legality, Profile
│   │   ├── Admin/          # Dashboard, UserVerification, MOU, OrderManagement, Finance, Settings
│   │   │   └── MasterData/ # Category, Product, Material, Packaging
│   │   └── CatalogController.php  # Public catalog + price calculator
│   ├── Middleware/         # EnsureAdmin, EnsureVerified, LogAudit
│   ├── Requests/Auth/      # RegisterRequest, LoginRequest
│   └── Resources/          # UserResource, OrderResource, InvoiceResource, PaymentResource
├── Models/                 # 19 Eloquent models
├── Policies/               # OrderPolicy, InvoicePolicy
├── Services/               # InvoiceService, MouService, NotificationService, PdfService
└── Providers/
    └── AppServiceProvider.php  # Policy registration
database/
├── migrations/             # 22 migration files
└── seeders/                # 6 seeders (admin, categories, materials, packaging, settings)
resources/views/pdf/        # invoice.blade.php, mou.blade.php
routes/api.php              # 88 API endpoints
```

---

## Setup & Instalasi

```bash
# Install dependencies
composer install

# Copy environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Setup database di .env lalu migrate + seed
php artisan migrate --seed

# Jalankan server
php artisan serve
```

### Konfigurasi `.env` Penting

```env
DB_CONNECTION=mysql
DB_DATABASE=maklon_db
DB_USERNAME=root
DB_PASSWORD=

GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URL=http://localhost:8000/api/auth/google/callback

FRONTEND_URL=http://localhost:3000
```

---

## Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@maklon.id | password123 |
| Admin Verifikasi | admin.verifikasi@maklon.id | password123 |
| Admin Produksi | admin.produksi@maklon.id | password123 |
| Admin Keuangan | admin.keuangan@maklon.id | password123 |

---

## API Endpoints (88 endpoint)

### Auth (Public)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/api/auth/register` | Registrasi customer baru |
| POST | `/api/auth/login` | Login dengan email/password |
| GET | `/api/auth/google/redirect` | Redirect ke Google OAuth |
| GET | `/api/auth/google/callback` | Callback Google OAuth |
| POST | `/api/auth/logout` | Logout |
| GET | `/api/auth/me` | Info user yang sedang login |
| POST | `/api/auth/change-password` | Ganti password |

### Catalog (Public, Tanpa Auth)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/catalog/categories` | Daftar kategori produk (tree 4-level) |
| GET | `/api/catalog/products` | Daftar produk dengan filter |
| GET | `/api/catalog/products/{id}` | Detail produk |
| GET | `/api/catalog/materials` | Daftar bahan add-on (140+) |
| GET | `/api/catalog/packaging` | Katalog kemasan dengan opsi |
| POST | `/api/catalog/calculate-price` | Kalkulator harga order real-time |

### Customer (Auth Required)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/customer/dashboard` | Dashboard statistik & notifikasi |
| GET/PUT | `/api/customer/profile` | Profil & data perusahaan |
| GET | `/api/customer/legality/status` | Status verifikasi legalitas |
| POST | `/api/customer/legality/upload-document` | Upload dokumen (Opsi A — gratis) |
| POST | `/api/customer/legality/buy-package` | Beli paket legalitas (Opsi B) |
| POST | `/api/customer/orders` | **Step 1**: Buat order (brand & legal) |
| PUT | `/api/customer/orders/{id}/step2` | **Step 2**: Pilih produk & volume |
| PUT | `/api/customer/orders/{id}/step3` | **Step 3**: Pilih material add-on |
| PUT | `/api/customer/orders/{id}/step4` | **Step 4**: Pilih kemasan |
| PUT | `/api/customer/orders/{id}/step5` | **Step 5**: Desain packaging |
| PUT | `/api/customer/orders/{id}/step5-sample` | **Step 5.5**: Request sample |
| POST | `/api/customer/orders/{id}/submit` | **Step 6**: Submit → generate invoice + MOU |
| GET | `/api/customer/orders/{id}/mou/download` | Download MOU PDF |
| POST | `/api/customer/orders/{id}/mou/upload-signed` | Upload MOU bertanda tangan |
| GET | `/api/customer/orders/{id}/tracking` | Real-time tracking produksi |
| GET | `/api/customer/invoices` | Daftar invoice |
| GET | `/api/customer/invoices/{id}/download` | Download invoice PDF |
| POST | `/api/customer/invoices/{id}/upload-payment` | Upload bukti pembayaran |

### Admin (Admin Role Required)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/admin/dashboard` | Dashboard + KPI real-time |
| GET | `/api/admin/verifications/pending` | Antrian verifikasi legalitas |
| POST | `/api/admin/verifications/users/{id}/approve` | Setujui legalitas user |
| POST | `/api/admin/verifications/users/{id}/reject` | Tolak legalitas user |
| GET | `/api/admin/mous/pending` | MOU pending review |
| POST | `/api/admin/mous/{id}/approve` | Approve MOU → unlock payment |
| POST | `/api/admin/mous/{id}/reject` | Reject MOU |
| GET | `/api/admin/orders` | Semua order dengan filter |
| PATCH | `/api/admin/orders/{id}/status` | Update status produksi |
| POST | `/api/admin/orders/{id}/shipping` | Input resi & kurir |
| GET | `/api/admin/payments/pending` | Pembayaran pending konfirmasi |
| POST | `/api/admin/payments/{id}/confirm` | Konfirmasi/tolak pembayaran |
| GET/POST | `/api/admin/master/categories` | CRUD kategori produk |
| GET/POST | `/api/admin/master/products` | CRUD produk |
| GET/POST | `/api/admin/master/materials` | CRUD bahan baku |
| GET/POST | `/api/admin/master/packaging/types` | CRUD jenis kemasan |
| GET | `/api/admin/finance/summary` | Laporan keuangan & revenue |
| GET/PUT | `/api/admin/settings` | Pengaturan sistem |
| GET | `/api/admin/settings/audit-logs` | Log semua aktivitas admin |

---

## Business Logic Utama

### Formula Kalkulasi Harga
```
base_cost        = base_price_per_100ml × (volume_ml / 100) × qty
material_cost    = Σ (price_per_ml × dose_ml × qty)
packaging_cost   = packaging_option_price × qty
design_cost      = Rp 750.000 (jika pilih jasa design)
sample_cost      = Rp 500.000 (jika request sample)

subtotal_product = base + material + packaging + design
ppn (11%)        = (subtotal_product + legal_cost + sample_cost) × 11%
grand_total      = subtotal_product + legal_cost + sample_cost + ppn

DP (Pembayaran 1)  = legal_cost + sample_cost + (subtotal_product × 50%) + ppn
Pelunasan          = subtotal_product × 50%
```

### Pricing Legalitas
| Item | Harga | Status |
|------|-------|--------|
| Izin Edar BPOM | Rp 1.250.000 | **Wajib** |
| Sertifikasi Halal | Rp 2.500.000 | Opsional |
| Logo & Pendaftaran Merek HAKI | Rp 1.500.000 | Opsional |
| Pendaftaran DJKI per Kelas | Rp 2.750.000 | Opsional |
| PT Perorangan | Rp 1.500.000 | Opsional (Opsi B) |
| PT Perseroan | Rp 5.000.000 | Opsional (Opsi B) |
| Desain Sticker | Rp 750.000 | Opsional |
| Request Sample | Rp 500.000 | Opsional |

### Gate / Lock Sistem
| Gate | Syarat |
|------|--------|
| Buat Order | Akun harus verified (legalitas approved) |
| Bayar DP | MOU harus diapprove admin terlebih dahulu |
| Mulai Produksi | Pembayaran DP harus dikonfirmasi admin |
| Kirim Produk | Pelunasan 50% harus dibayar |

---

## Data Master (Seeder)

| Data | Jumlah |
|------|--------|
| Kategori Produk | 7 kategori utama, 3-level hierarki |
| Material Bahan | 100 bahan (27 Extract, 23 Oil, 35 Active, 15 Perfume) |
| Jenis Kemasan | 10 tipe × 32 opsi total |
| System Settings | 24 setting |
| Admin Accounts | 4 admin roles |
