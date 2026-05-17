# 🧺 BersihKilat Laundry — Laravel MVC

Sistem manajemen pesanan laundry berbasis Laravel MVC.

## Struktur File

```
app/
├── Models/
│   └── Pesanan.php                          ← Model
├── Http/Controllers/
│   └── PesananController.php                ← Controller
resources/
└── views/
    └── pesanan/
        └── index.blade.php                  ← View
database/
└── migrations/
    └── 2024_01_01_000000_create_pesanans_table.php  ← Migration
routes/
└── web.php                                  ← Routes
```

## Cara Instalasi

### 1. Buat project Laravel baru
```bash
composer create-project laravel/laravel laundry-app
cd laundry-app
```

### 2. Copy semua file dari ZIP ini ke project
Salin setiap file ke path yang sesuai di dalam project Laravel kamu.

### 3. Setting database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundry_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat database
```sql
CREATE DATABASE laundry_db;
```

### 5. Jalankan migration
```bash
php artisan migrate
```

### 6. Jalankan server
```bash
php artisan serve
```

### 7. Buka browser
```
http://localhost:8000
```

---

## Fitur
- ✅ Tambah pesanan baru
- ✅ Hitung harga otomatis berdasarkan jenis layanan & berat
- ✅ Update status pesanan (menunggu → proses → selesai → diambil)
- ✅ Hapus pesanan
- ✅ Dashboard statistik (total pesanan, menunggu, diproses, pendapatan)
- ✅ Validasi form

## Harga Layanan
| Layanan       | Harga/kg   |
|---------------|------------|
| Cuci + Setrika| Rp 7.000   |
| Cuci Biasa    | Rp 5.000   |
| Setrika       | Rp 3.000   |
| Express       | Rp 12.000  |
| Dry Clean     | Rp 20.000  |
