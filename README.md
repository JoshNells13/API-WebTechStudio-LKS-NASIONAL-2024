# 📘 Web Tech Studio – Course Platform API (MASIH DALAM PENGEMBANGAN MAAF KALAU SALAH HEHEHE)

Backend API untuk **platform pembelajaran online** berbasis **Laravel + Sanctum** yang dikembangkan sebagai **soal LKS Nasional 2024 bidang Web Technologies**.

Proyek ini bernama **Web Tech Studio** dan berfokus pada penerapan REST API, autentikasi aman, serta manajemen course yang terstruktur sesuai standar kompetisi nasional.



---

## 🔐 Authentication

Menggunakan **Laravel Sanctum** untuk autentikasi berbasis token.

### Register

```http
POST /api/register
```

### Login

```http
POST /api/login
```

### Logout *(Auth Required)*

```http
POST /api/logout
```

---

## 👤 User

### Get Authenticated User

```http
GET /api/user
```

**Middleware:** `auth:sanctum`

### Get User Progress

```http
GET /api/users/progress
```

Menampilkan progres course yang sedang atau sudah diikuti user.

---

## 📚 Courses

### Get All Courses

```http
GET /api/courses
```

### Get Course Detail

```http
GET /api/courses/{slug}
```

### Add Course

```http
POST /api/courses
```

### Edit Course

```http
PUT /api/courses/{slug}
```

### Delete Course

```http
DELETE /api/courses/{slug}
```

---

## 🧩 Course Sets (Module)

### Add Set to Course

```http
POST /api/courses/{course}/sets
```

### Delete Set

```http
DELETE /api/courses/{course}/sets/{id}
```

---

## 📖 Lessons

### Add Lesson

```http
POST /api/lessons
```

### Delete Lesson

```http
DELETE /api/lessons/{id}
```

### Check Lesson Content

```http
POST /api/lessons/{id}/content/{idcontent}/check
```

Digunakan untuk validasi atau penandaan konten lesson.

### Complete Lesson

```http
PUT /api/lessons/{id}/complete
```

Menandai lesson sebagai selesai oleh user.

---

## 📝 Course Registration

### Register User to Course

```http
POST /api/courses/{slug}/register
```

User mendaftar ke course tertentu.

---

## 🛡 Middleware

Semua endpoint (kecuali login & register) dilindungi oleh:

```
auth:sanctum
```

---

## 🏆 Konteks LKS Nasional 2024

Proyek **Web Tech Studio** dibuat sebagai bagian dari **Lomba Kompetensi Siswa (LKS) Nasional 2024** bidang **Web Technologies**.

Fokus penilaian meliputi:

* Perancangan REST API yang rapi dan konsisten
* Implementasi autentikasi menggunakan token
* Struktur kode Laravel yang scalable
* Kesiapan integrasi dengan frontend modern

---

## 🧠 Tech Stack

* **Laravel** (REST API)
* **Laravel Sanctum** (Authentication)
* **MySQL / PostgreSQL** (Database)
* **Frontend Ready** (React / Next.js / Mobile)

---

## 📌 Catatan Developer

* Gunakan header berikut untuk request terautentikasi:

```http
Authorization: Bearer <token>
```

---

## 📚 Referensi Resmi

* Dokumentasi resmi Laravel
* Dokumentasi Laravel Sanctum
* Best Practice REST API

---



