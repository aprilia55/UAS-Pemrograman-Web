# LET’S COOK  
### Aplikasi Web Resep Masakan Berbasis PHP & MySQL

**Nama Mahasiswa** : Alfarizki Aprilia Putri
**NIM**            : 312410455  
**Kelas**          : TI.24.A5
**Mata Kuliah**    : Pemrograman Web  
**Jenis Tugas**    : Ujian Akhir Semester (UAS)

---

Aplikasi **Let’s Cook** merupakan aplikasi web berbasis **PHP dan MySQL** yang dikembangkan untuk mengelola data resep masakan secara dinamis. Aplikasi ini dibuat sebagai bentuk penerapan materi Pemrograman Web yang mencakup konsep **CRUD (Create, Read, Update, Delete)**, **autentikasi pengguna**, **session**, **pagination**, **pencarian data**, serta **pembagian hak akses (Admin dan User)**.

Sistem pada aplikasi ini mengharuskan pengguna untuk melakukan login terlebih dahulu. Hak akses Admin digunakan untuk mengelola data resep, sedangkan User hanya dapat melihat resep, melihat detail resep, dan menyimpan resep favorit. Seluruh halaman penting dilindungi menggunakan session sehingga hanya dapat diakses oleh pengguna yang telah terautentikasi.

---

## 📁 Struktur Folder Aplikasi

Struktur folder disusun secara terorganisir untuk memudahkan pengelolaan dan pengembangan aplikasi:

```text
lets_cook
│
├── auth
│   ├── login.php
│   └── logout.php
│
├── config
│   └── database.php
│
├── dashboard
│   ├── index.php
│   ├── favorites.php
│   ├── detail_recipe.php
│   ├── add_favorite.php
│   │
│   └── admin
│       ├── index.php
│       ├── recipes.php
│       ├── add_recipe.php
│       ├── edit_recipe.php
│       └── delete_recipe.php
│
├── uploads
│   └── default.jpeg
│
├── index.php
└── README.md
```

---

## 🗄️ Database

Aplikasi ini menggunakan database **MySQL** dengan nama `lets_cook` yang terdiri dari beberapa tabel utama, yaitu:

- **users** → menyimpan data akun pengguna
- **recipes** → menyimpan data resep masakan
- **favorites** → menyimpan data resep favorit user

Password pengguna disimpan dalam bentuk hash menggunakan fungsi `password_hash()` dan diverifikasi menggunakan `password_verify()` untuk menjaga keamanan data.

---

## ⚙️ Fitur Aplikasi

Fitur-fitur utama yang tersedia pada aplikasi Let’s Cook meliputi:

- Login dan Logout pengguna
- Autentikasi dan session
- Dashboard resep
- CRUD data resep (Admin)
- Upload gambar resep
- Pencarian resep
- Pagination data resep
- Detail resep
- Fitur favorit resep
- Pembatasan akses halaman berdasarkan role

---

## ▶️ Cara Menjalankan Aplikasi

1. Aktifkan **Apache** dan **MySQL** melalui XAMPP  
2. Letakkan folder project di direktori:
   ```
   C:\xampp\htdocs\lets_cook
   ```
3. Import database ke **phpMyAdmin**
4. Akses aplikasi melalui browser:
   ```
   http://localhost/lets_cook
   ```

---

## ✅ Hasil Pengujian

- Login dan logout berjalan dengan baik
- Session berhasil melindungi halaman admin
- CRUD resep berjalan normal
- Pagination menampilkan data sesuai halaman
- Pencarian resep berfungsi dengan baik
- Tampilan aplikasi responsif dan rapi

---

## 📝 Kesimpulan

Berdasarkan hasil implementasi dan pengujian, aplikasi **Let’s Cook** telah berhasil dibangun sesuai dengan kebutuhan dan memenuhi standar penilaian **Ujian Akhir Semester Mata Kuliah Pemrograman Web**. Aplikasi ini mampu menerapkan konsep dasar pengembangan web secara terstruktur, aman, dan terintegrasi menggunakan PHP dan MySQL.
