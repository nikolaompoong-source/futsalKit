# FutsalKit - Sistem Manajemen Turnamen & Jadwal Pertandingan Futsal

Aplikasi web dinamis ini dirancang khusus untuk memenuhi kriteria penilaian UAS mata kuliah **Pengembangan Aplikasi Web Dinamis (PWD)**. Sistem ini dibangun dengan arsitektur **MVC (Model-View-Controller) buatan sendiri (Native)** tanpa menggunakan framework pihak ketiga seperti Laravel atau CodeIgniter.

---

## 🚀 Fitur Utama & Kepatuhan UAS

1. **Arsitektur & Database**:
   - Pola desain **MVC Mandiri** yang bersih dan terstruktur.
   - Gerbang Tunggal (**Front Controller**) di `index.php` dan **Clean URL** menggunakan `.htaccess` Apache.
   - Koneksi database **PDO (PHP Data Objects)** aman dengan **Prepared Statements** untuk proteksi SQL Injection.
2. **Autentikasi & RBAC (Role-Based Access Control)**:
   - Pengamanan password menggunakan enkripsi bawaan PHP `password_hash()`.
   - **2 Peran Pengguna (Role)** yang berbeda:
     - **Admin**: Memiliki hak akses penuh untuk memvalidasi pendaftaran tim (Approve/Reject), mengelola jadwal pertandingan, dan memasukkan hasil skor akhir.
     - **Manager**: Mendaftarkan tim futsal baru, mengelola roster pemain (CRUD + upload berkas identitas).
   - **URL Protection**: Proteksi otorisasi sisi server (backend-side) untuk mengamankan halaman khusus Admin agar tidak ditembak langsung oleh Manager.
3. **Fitur CRUD & Validasi**:
   - Operasi CRUD terintegrasi yang melibatkan **4 tabel berelasi** (`users`, `teams`, `players`, `matches`).
   - Data seed demo berisi **5 akun Manager**, **5 tim futsal**, dan **50 pemain**. Setiap tim memiliki roster lengkap berisi **5 Pemain Inti** dan **5 Pemain Cadangan**.
   - Seed demo sudah dilengkapi **logo tim**, **foto pemain**, dan **kartu identitas pemain** unik untuk setiap pemain.
   - **Fitur Upload File**: Upload logo tim, foto pemain, dan dokumen kartu identitas pemain dengan validasi ketat di sisi server (maksimal 2MB).
   - **Server-Side Validation**: Validasi data kosong, format email unik, dan tipe data numerik (nomor punggung/skor).
   - **Try-Catch Block**: Penanganan error database secara elegan untuk menyembunyikan query SQL mentah dari user.
4. **UI Templating**:
   - Tampilan antarmuka responsif dan konsisten berbasis **Tailwind CSS CDN** dan **Bootstrap Icons** dengan desain modern gelap (Dark Theme) bernuansa olahraga.
   - Halaman login dilengkapi panel akun demo dengan fitur copy email dan password.

---

## 🛠️ Langkah Instalasi di Lokal (Laragon / XAMPP)

1. **Pindahkan Folder Proyek**:
   Letakkan folder `FutsalKit` ini di direktori root server lokal Anda:
   - **Laragon**: `C:\laragon\www\FutsalKit` atau `D:\laragon\www\FutsalKit`
   - **XAMPP**: `C:\xampp\htdocs\FutsalKit`

2. **Aktifkan Server**:
   Jalankan server Apache dan MySQL di Laragon atau XAMPP Panel Anda.

3. **Import Database**:
   - Buka MySQL manager Anda (seperti phpMyAdmin, Adminer, atau HeidiSQL).
   - Buat database baru dengan nama `futsalkit`.
   - Import / jalankan file dump database `futsalkit.sql` yang berada di root direktori proyek ini.

4. **Akses Aplikasi**:
   Buka browser Anda dan jalankan URL berikut:
   `http://localhost/FutsalKit`

---

## 🔑 Akun Demo Pengujian

Gunakan akun sampel berikut untuk menguji fitur otorisasi sistem. Semua akun manager menggunakan password `manager123`.

| Peran (Role) | Email | Password | Hak Akses |
|---|---|---|---|
| **Admin** | `admin@futsalkit.com` | `admin123` | Menyetujui tim, kelola jadwal & skor pertandingan |
| **Manager (Approved)** | `manager@futsalkit.com` | `manager123` | Mengelola roster pemain (tim: FC Barcelona Futsal) |
| **Manager (Pending)** | `madrid@futsalkit.com` | `manager123` | Menunggu persetujuan tim (tim: Real Madrid Futsal) |
| **Manager (Approved)** | `manchester@futsalkit.com` | `manager123` | Mengelola roster pemain (tim: Manchester City Futsal) |
| **Manager (Approved)** | `garuda@futsalkit.com` | `manager123` | Mengelola roster pemain (tim: Garuda United Futsal) |
| **Manager (Pending)** | `nusantara@futsalkit.com` | `manager123` | Menunggu persetujuan tim (tim: Nusantara Warriors Futsal) |

---

## ⚽ Data Tim & Roster Demo

Setiap tim pada seed database memiliki **10 pemain lengkap**:

- **5 Pemain Inti**: Kiper, Anchor, Flank Kanan, Flank Kiri, dan Pivot.
- **5 Pemain Cadangan**: Kiper, Anchor, Flank Kanan, Flank Kiri, dan Pivot.
- Setiap pemain memiliki foto di folder `uploads/photos` dan kartu identitas unik di folder `uploads/identities`.
- Setiap tim memiliki logo di folder `uploads/logos`.

| Manager | Tim | Status | Jumlah Pemain |
|---|---|---|---|
| Manajer Barcelona | FC Barcelona Futsal | Approved | 10 pemain |
| Manajer Madrid | Real Madrid Futsal | Pending | 10 pemain |
| Manajer Manchester | Manchester City Futsal | Approved | 10 pemain |
| Manajer Garuda | Garuda United Futsal | Approved | 10 pemain |
| Manajer Nusantara | Nusantara Warriors Futsal | Pending | 10 pemain |

---

## 📂 Struktur File Utama

- `index.php`: Gerbang utama aplikasi (Front Controller & router dispatcher).
- `.htaccess`: Konfigurasi clean URL rewriting Apache.
- `futsalkit.sql`: File SQL berisi struktur tabel & data sampel.
- `/app/core`: Kelas inti framework kustom (`App.php`, `Controller.php`, `Database.php`, `Session.php`).
- `/app/controllers`: Kontroler yang memproses data & request.
- `/app/models`: Model database relasional (`User.php`, `Team.php`, `Player.php`, `Match.php`).
- `/app/views`: Tampilan antarmuka pengguna berbasis Tailwind CSS.
- `/uploads`: Penyimpanan berkas unggahan logo tim (`/logos`), foto pemain (`/photos`), dan identitas pemain (`/identities`).

---

## 👥 Contributor

| Nama | NIM |
|---|---|
| Nikola Charloveen | 24042231050 |
| Arif Ramadhan | 24042231038 |
