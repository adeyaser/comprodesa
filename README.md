# Portal Resmi Desa Kalibaru (Medan Satria)

Website profile desa modern yang dibangun menggunakan CodeIgniter 4, dirancang untuk memberikan informasi berita, potensi wisata, dan layanan publik secara transparan kepada masyarakat.

## ✨ Fitur Utama

- **Real-time News Scraper:** Otomatis mengambil berita terbaru dari portal eksternal (GoBekasi, dll) dengan filter khusus wilayah Kalibaru & Bekasi.
- **Content Management:** Berita lokal, profil desa, dan layanan publik yang dinamis.
- **Potensi Wisata:** Showcase destinasi wisata lokal lengkap dengan galeri foto.
- **Layanan Desa:** Informasi lengkap mengenai syarat dan prosedur layanan administrasi (KTP, KK, SKCK, dll).
- **Mobile Responsive:** Tampilan premium yang optimal di berbagai perangkat.

## 🛠️ Teknologi

- **Backend:** PHP 8.2 (CodeIgniter 4.6)
- **Frontend:** Bootstrap 5, Bootstrap Icons, Google Fonts (Inter)
- **Database:** MySQL/MariaDB
- **Library Khusus:** Scraper menggunakan cURL & DOMDocument (Native PHP) dengan sistem Caching.

## 🚀 Cara Instalasi (Lokal)

1. Clone repository ini.
2. Jalankan `composer install`.
3. Rename `env` menjadi `.env` dan sesuaikan kredensial database.
4. Jalankan migrasi dan seeder:

   ```bash
   php spark migrate
   php spark db:seed KaliBaruSeeder
   php spark db:seed ScrapingSourcesSeeder
   php spark db:seed TourismSpotSeeder
   php spark db:seed VillageServiceSeeder
   ```

5. Jalankan server: `php spark serve`

## 🔐 Akses Admin

Untuk masuk ke dashboard pengelolaan, gunakan tautan berikut:

- **URL Login:** [http://localhost:8080/login](http://localhost:8080/login)
- **Username:** `admin`
- **Password:** `admin123`

## 🌐 Panduan Deployment (Production)

### Langkah-langkah Deployment:

1. **Upload semua file** ke root directory hosting (kecuali folder yang di .gitignore).

2. **Konfigurasi Environment Production:**
   - Salin `.env.production` ke `.env`
   - Ubah `CI_ENVIRONMENT = production`
   - Sesuaikan `app.baseURL` dengan URL domain Anda
   - Isi kredensial database production
   - Generate encryption key: `php spark key:generate`

3. **Konfigurasi .htaccess untuk Production:**
   - Salin `.htaccess.production` ke `.htaccess` (root)
   - Salin `public/.htaccess.production` ke `public/.htaccess`
   - Sesuaikan `RewriteBase` jika aplikasi tidak di root domain

4. **Set Permission Folder:**
   ```bash
   chmod -R 755 writable/
   chmod -R 755 public/uploads/
   ```

5. **Jalankan Migrasi di Server:**
   ```bash
   php spark migrate --all
   ```

### Checklist Keamanan Production:

- [x] `CI_ENVIRONMENT = production`
- [x] Encryption key sudah di-generate
- [x] Password database yang kuat
- [x] HTTPS/SSL aktif
- [x] File `.env` tidak bisa diakses publik
- [x] Folder `writable/`, `app/`, `vendor/`, `tests/` tidak bisa diakses publik
- [x] Error reporting dimatikan (automatic di production)

### File Konfigurasi Production:

| File | Deskripsi |
|------|-----------|
| `.env.production` | Template konfigurasi production |
| `.htaccess.production` | Root htaccess untuk production |
| `public/.htaccess.production` | Public htaccess dengan security headers |

---
&copy; 2026 Pemerintah Kelurahan Kalibaru.
