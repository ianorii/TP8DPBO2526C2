# TP8DPBO2526C2
TUGAS PRAKTIKUM 8 DPBO MVC PHP Muhammad Rian Anugrah (2507241) Ilmu Komputer C2 Universitas Pendidikan Indonesia

Aplikasi web berbasis **PHP Native + MySQL** dengan arsitektur **MVC (Model–View–Controller)**.  
Digunakan untuk mengelola data:

- Lecturers (Dosen)
- Courses (Mata Kuliah)
- Research (Penelitian)

Semua tabel memiliki fitur **CRUD (Create, Read, Update, Delete)** dan tampilan menggunakan **Bootstrap**.

---

## 🚀 Fitur Utama

| Modul | Fitur |
|-------|-------|
| Lecturers | Create, Read, Edit, Delete |
| Courses | Create, Read, Edit, Delete + relasi ke Lecturer |
| Research | Create, Read, Edit, Delete + relasi ke Lecturer |

### Relasi
- LECTURERS (1) ────< (Many) COURSES
- LECTURERS (1) ────< (Many) RESEARCH


Courses & Research menggunakan **dropdown untuk memilih Lecturer**, dan index menampilkan **ID + nama lecturer**.

---

## 📂 Struktur Folder
```
tp_mvc26/
│
├── app/
│   ├── controllers/
│   │   ├── LecturerController.php
│   │   ├── CourseController.php
│   │   └── ResearchController.php
│   │
│   ├── models/
│   │   ├── Lecturer.php
│   │   ├── Course.php
│   │   └── Research.php
│   │
│   ├── views/
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── lecturers/ (index, create, edit, _form)
│   │   ├── courses/ (index, create, edit, _form)
│   │   └── research/ (index, create, edit, _form)
│   │
│   └── core/
│       ├── Database.php
│       └── Config.php
│
├── public/
│   ├── index.php   ← Router
│   └── assets/     ← bootstrap.min.css, bootstrap.bundle.min.js
│
├── db_passwordnya_admin123.sql
|
└── README.md
```

## 🧩 DESAIN PROGRAM — ARSITEKTUR MVC

Program dirancang agar setiap lapisan memiliki tanggung jawab yang jelas — View tidak berisi query database, Controller tidak berisi HTML, Model tidak berurusan dengan router.

```
┌─────────────┐      ┌─────────────┐      ┌──────────────┐
│ Controller  │ ---> │   Model     │ ---> │   Database   │
└──────┬──────┘      └─────┬───────┘      └──────┬───────┘
       │                   │                     │
       ▼                   ▼                     │
  menerima request   mengelola data            query SQL
       │                                         │
       ▼                                         │
┌──────┴──────┐                                  │
│    View     │ <--------------------------------┘
└─────────────┘
menampilkan UI kepada user
```

## 📁 Penjelasan Folder `app/` — MVC Architecture Overview

Folder `app/` merupakan inti utama aplikasi dan berisi seluruh komponen pola arsitektur **MVC (Model – View – Controller)**.  
Struktur di dalamnya terdiri dari 4 subfolder:
```
app/
├─ controllers/
├─ models/
├─ views/
└─ core/
```
Setiap bagian memiliki peran spesifik seperti berikut.

---

### 🧠 `controllers/` — Pengatur Alur Aplikasi
Berisi file **Controller**, yaitu bagian yang menerima request dari router kemudian menghubungkan View (<– user) dengan Model (<– database).

| File | Fungsi |
|------|--------|
| `LecturerController.php` | Mengatur CRUD untuk Lecturers |
| `CourseController.php` | Mengatur CRUD untuk Courses |
| `ResearchController.php` | Mengatur CRUD untuk Research |

Controller bertanggung jawab untuk:
- menerima aksi pengguna (klik menu, submit form, edit, delete)
- meminta data ke Model
- mengirimkan data ke View untuk ditampilkan

Tanpa controller, View akan bercampur dengan SQL dan menjadi tidak modular.

---

### 🗄 `models/` — Logika Database
Berisi **Model**, yaitu bagian yang berhubungan langsung dengan database melalui kelas `Database`.

| File | Fungsi |
|------|--------|
| `Lecturer.php` | Query pada tabel lecturers |
| `Course.php` | Query pada tabel courses |
| `Research.php` | Query pada tabel research |

Model berisi operasi:
- `all()` — mengambil banyak data
- `find()` — mengambil satu data berdasarkan ID
- `create()` — menambahkan data baru
- `update()` — memperbarui data
- `delete()` — menghapus data

Model **tidak** menampilkan HTML dan **tidak** menangani request pengguna.

---

### 👁 `views/` — Tampilan HTML / UI
Berisi semua file **View**, yaitu tampilan yang dilihat pengguna.
```
views/
├─ lecturers/
│ ├─ index.php
│ ├─ create.php
│ ├─ edit.php
│ └─ _form.php
├─ courses/
│ ├─ index.php
│ ├─ create.php
│ ├─ edit.php
│ └─ _form.php
├─ research/
│ ├─ index.php
│ ├─ create.php
│ ├─ edit.php
│ └─ _form.php
├─ header.php
└─ footer.php
```
---

### ⚙ `core/` — Mesin MVC (Engine)
Berisi class inti yang membuat MVC dapat berjalan.

| File | Fungsi |
|------|--------|
| `Config.php` | Membuat `BASE_URL` otomatis untuk asset dan redirect serta konfigurasi DB |
| `Database.php` | Mengatur koneksi database PDO (singleton) |

Peran utama `core/`:
- memastikan aplikasi tetap **portable** (tidak perlu ubah config walaupun nama folder berbeda)
- mengelola koneksi database secara terpusat dan aman menggunakan prepared statement PDO

---

## 🔗 Hubungan antar folder dalam `app/`

```
View  ↔  Controller  ↔  Model  ↔  Database
            ▲
            │
      Router (public/index.php)
```

# 💿 DATABASE
<img width="669" height="212" alt="Screenshot 2025-11-16 at 00 45 48" src="https://github.com/user-attachments/assets/5f94f78b-5ba5-41dd-b0e5-491376a975dc" />
<br>

## 🗄 Penjelasan Database

Database pada aplikasi ini digunakan untuk menyimpan data **Lecturers**, **Courses**, dan **Research**.  
Struktur database dibuat dengan konsep **relasi satu–ke–banyak (one-to-many)** antara tabel **lecturers** dengan tabel **courses** serta **research**.

---

### 📌 Daftar Tabel

Database terdiri dari **3 tabel utama**:

| Tabel | Fungsi |
|-------|--------|
| `lecturers` | Menyimpan data dosen |
| `courses` | Menyimpan data mata kuliah dan relasi ke dosen |
| `research` | Menyimpan data penelitian dan relasi ke dosen |

---

### 📍 Struktur Tabel `lecturers`
Digunakan sebagai **tabel induk** untuk mengelola identitas dosen.

| Field | Tipe | Keterangan |
|-------|------|-------------|
| `id` | INT UNSIGNED (PK, Auto Increment) | Primary key |
| `name` | VARCHAR(100) | Nama dosen |
| `nidn` | VARCHAR(20) | Nomor induk dosen nasional (Unique) |
| `email` | VARCHAR(100) | Email dosen |
| `phone` | VARCHAR(20) | Nomor telepon |
| `join_date` | DATE | Tanggal bergabung |

---

### 📍 Struktur Tabel `courses`
Menyimpan daftar mata kuliah dan **menghubungkannya dengan dosen** melalui `lecturer_id`.

| Field | Tipe | Keterangan |
|-------|------|-------------|
| `id` | INT UNSIGNED (PK, Auto Increment) | Primary key |
| `lecturer_id` | INT UNSIGNED (FK) | Relasi ke `lecturers.id` |
| `code` | VARCHAR(10) | Kode mata kuliah (Unique) |
| `name` | VARCHAR(100) | Nama mata kuliah |
| `sks` | TINYINT UNSIGNED | Jumlah SKS |
| `semester` | TINYINT UNSIGNED | Semester pengajaran |

---

### 📍 Struktur Tabel `research`
Menyimpan data penelitian dosen.

| Field | Tipe | Keterangan |
|-------|------|-------------|
| `id` | INT UNSIGNED (PK, Auto Increment) | Primary key |
| `lecturer_id` | INT UNSIGNED (FK) | Relasi ke `lecturers.id` |
| `title` | VARCHAR(150) | Judul penelitian |
| `year` | SMALLINT UNSIGNED | Tahun penelitian |
| `funding` | DECIMAL(12,2) | Pendanaan penelitian |

---

## 🛠️ Panduan Instalasi & Menjalankan

1. **Letakkan Proyek:**  
   Pastikan folder proyek berada di direktori web server (misalnya `/opt/lampp/htdocs/TP8DPBO2526C2/` atau `C:/xampp/htdocs/TP8DPBO2526C2/`).

2. **Import Database:**  
   Database default bernama `tp_mvc26` dengan user `root` dan password `admin123`.  
   Import via terminal:
   ```bash
   mysql -u root -padmin123 < db_passwordnya_admin123.sql
   ```
   Atau melalui **phpMyAdmin** → Tab **Import** → Pilih file `db_passwordnya_admin123.sql`.

3. **Akses Aplikasi:**  
   Buka browser dan akses URL:
   ```
   http://localhost/TP8DPBO2526C2/tp_mvc26/public/
   ```

---

# 📸 DEMO
https://github.com/user-attachments/assets/393152ab-2ff9-4590-83e1-8b4c6bd8b3bd

