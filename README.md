# Let’s Cook – Aplikasi Resep Masakan Berbasis Web

**Nama:** Alfarizki Aprilia Putri 

**NIM:** 312410455

**Kelas:** TI.24.A5  

Repository ini berisi **hasil pengembangan aplikasi web Let’s Cook** yang dibuat sebagai **Tugas Ujian Akhir Semester (UAS)** pada mata kuliah **Pemrograman Web / Basis Data**.  
Aplikasi dikembangkan menggunakan **PHP Native dan MySQL** dengan penerapan autentikasi, manajemen session, pagination, serta pengelolaan data berbasis role pengguna (**Admin & User**).

---

## Deskripsi Aplikasi

Let’s Cook merupakan aplikasi web yang digunakan untuk **menampilkan, mengelola, dan menyimpan resep masakan**.  
Aplikasi ini memungkinkan pengguna untuk mencari resep, melihat detail resep, serta menyimpan resep favorit.  
Admin memiliki hak akses penuh untuk mengelola data resep melalui **Admin Panel**.

---

## Tujuan Pembuatan Aplikasi

1. Menerapkan konsep CRUD (Create, Read, Update, Delete).
2. Menerapkan autentikasi dan session pada PHP.
3. Menerapkan pembagian hak akses berdasarkan role user.
4. Menghubungkan aplikasi web dengan database MySQL.
5. Membangun aplikasi web dengan struktur folder yang rapi dan terorganisir.

---

## Fitur Aplikasi

### Fitur Umum
- Login dan Logout
- Dashboard utama
- Pencarian resep
- Pagination data resep
- Upload dan tampil gambar resep
- Detail resep

### Fitur User
- Melihat daftar resep
- Mencari resep
- Melihat detail resep
- Menyimpan resep ke favorit

### Fitur Admin
- Mengelola data resep (Tambah, Edit, Hapus)
- Melihat seluruh data resep
- Mengakses Admin Panel

---

## Struktur Folder Project
lets_cook/
├── auth/
│   ├── login.php
│   └── logout.php
│
├── config/
│   └── database.php
│
├── dashboard/
│   ├── index.php
│   ├── favorites.php
│   ├── detail_recipe.php
│   ├── add_favorite.php
│   │
│   └── admin/
│       ├── index.php
│       ├── recipes.php
│       ├── add_recipe.php
│       ├── edit_recipe.php
│       └── delete_recipe.php
│
├── uploads/
│   └── (gambar resep)
│
├── index.php
└── README.md
