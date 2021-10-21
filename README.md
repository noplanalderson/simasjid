***
Mengenal Aplikasi SIMASJID
***
![SIMASJID](https://raw.githubusercontent.com/noplanalderson/simasjid/main/_/images/simasjid_logo.png)

Aplikasi SIMASJID (Sistem Informasi dan Manajemen Masjid) adalah sebuah aplikasi gratis
yang bisa digunakan dan dikembangkan secara bebas oleh umat Islam, khususnya pengurus masjid.
Aplikasi ini in syaa Allah akan mempermudah pengurus masjid untuk melakukan manajemen pada masjid
seperti manajemen keuangan, zakat, agenda kegiatan, dan dokumentasi. Aplikasi ini dilengkapi juga 
dengan modul audit yang bisa digunakan untuk mengaudit keuangan masjid jika diperlukan.

*******************
Informasi Rilis
*******************

Versi terbaru dari aplikasi SIMASJID adalah v1.5.1 yang bisa diunduh pada link 'Release' di halaman ini.

**************************
Fitur-fitur
**************************

- Manajemen Akses/Role
- Manajemen User
- Pengaturan Masjid
- Pengaturan SMTP
- Utilitas
- Dashboard
- Manajemen Keuangan
- Manajemen Zakat Fitrah dan Zakat Mal
- Manajemen Inventaris
- Manajemen Agenda dan Kegiatan
- Dokumentasi Agenda Kegiatan
- Database Mustahik dan Warga yang berhak disantuni
- Kalkulator Zakat
- Memo
- Pengaturan Akun
- Lupa Password

*******************
Server Requirements
*******************

- PHP Versi >=7.4
- Apache atau Nginx Webserver
- Database MariaDB versi 10.x
- atau bisa menggunakan XAMPP pada Sistem Operasi Windows
- Email sebagai SMTP  (Silakan baca panduan [berikut](https://www.dewaweb.com/blog/cara-setting-smtp-gmail/))

************
Instalasi
************

- Buat database pada MariaDB atau jika anda menggunakan XAMPP, gunakan phpmyadmin.
- Simpan folder aplikasi SIMASJID pada root directory webserver anda. Jika menggunakan XAMPP, letakkan folder aplikasi pada C:\\\\xampp\\htdocs
- Ubah variabel $webdir pada file index.php, sesuaikan isinya dengan nama direktori aplikasi simasjid. Misal nama direktori adalah simasjid maka $webdir = '/simasjid' (WAJIB DIIKUTI DENGAN TANDA SLASH DI AWAL)
- Akses http://domain/install.php atau jika masih menggunakan webserver lokal seperti XAMPP, silakan akses http://localhost/simasjid/install.php
- Masukkan nama database, user database, dan password database
- Ikuti langkah-langkah selanjutnya

*********
Lain-lain
*********

Laporkan celah keamanan atau bug ke email [berikut](mailto:mrnaeem@tutanota.com)
