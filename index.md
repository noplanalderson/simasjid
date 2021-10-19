## SIMASJID

![SIMASJID](https://raw.githubusercontent.com/noplanalderson/simasjid/main/_/images/simasjid_logo.png)

Sebelum melakukan instalasi, pastikan bahwa server/hosting/PC anda telah memenuhi _system requirements_ sebagai berikut:

1. Sistem Operasi 64 bit (Linux/Windows/MacOS) 
2. Mendukung Bahasa Pemrograman PHP Versi >=7.4
3. Apache atau Nginx Webserver
4. Database MariaDB versi 10.x
5. Mendukung _library_ PHP Sodium dan PHP GD
6. Jika memakai Nginx Webserver, pastika anda menginstal PHP-FPM
7. atau bisa menggunakan XAMPP
8. Email yang mendukung SMTP Client ([Silakan baca panduan berikut](https://www.dewaweb.com/blog/cara-setting-smtp-gmail/))

### Prosedur Instalasi Aplikasi SIMASJID

1. Unduh dan simpan folder aplikasi SIMASJID pada root directory webserver anda. Jika menggunakan XAMPP, letakkan folder aplikasi pada `C:\\xampp\htdocs`.
2. Buat database pada MariaDB atau jika anda menggunakan XAMPP bisa menggunakan phpmyadmin.
3. Jika folder aplikasi SIMASJID tidak menjadi web root anda, maka pada file `index.php` ubahlah variabel berikut

   ```
   $webdir = '';
   ```
   menjadi
   
   ```
   $webdir = 'nama_folder_simasjid';
   ```
   atau biarkan kosong jika web root anda langsung mengarah pada folder aplikasi SIMASJID.
4. Akses `http://domain.anda/install.php` atau jika masih menggunakan webserver lokal seperti XAMPP, silakan akses `http://localhost/nama_folder/install.php`.
5. Masukkan nama database yang telah dibuat, user database, dan password database.
6. Lalu ikuti langkah-langkah konfigurasi selanjutnya.

### Kontak dan Dukungan

Jika mengalami kesulitan dalam proses instalasi, atau menemukan bug dan celah keamanan, silakan kirimkan email beserta _screenshoot_ ke email [berikut](mailto:mrnaeem@tutanota.com).
