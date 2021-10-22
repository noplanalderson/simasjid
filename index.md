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
   $webdir = '/nama_folder_simasjid';
   ```
   atau biarkan kosong jika web root anda langsung mengarah pada folder aplikasi SIMASJID.
4. Akses `http://domain.anda/install.php` atau jika masih menggunakan webserver lokal seperti XAMPP, silakan akses `http://localhost/nama_folder/install.php`.
5. Masukkan nama database yang telah dibuat, user database, dan password database.
6. Lalu ikuti langkah-langkah konfigurasi selanjutnya.

### Rekomendasi dan Konfigurasi Keamanan

1. Disarankan menggunakan _non root_ user untuk database dan kata sandi yang kuat.
2. Menggunakan _secure connection_ atau Protokol HTTPS.
3. Mengaktifkan fitur _Content Security Policy_ untuk mencegah serangan XSS dengan mengubah variabel berikut:
   ```
   # Baris ke 599, ubah dari false menjadi true
   $config['csp_header'] = true;
   ```
4. Mengaktifkan _cookie secure_ untuk mencegah pencurian _cookie_ (Hanya diaktifkan jika koneksi menggunakan HTTPS)
   ```
   # Baris 419
   $config['cookie_secure'] = true;
   ```
5. Mengubah `block_all_mixed_contents` dan `upgrade_insecure_requests` pada _file_ `app/config/csp.php` menjadi true (Hanya diaktifkan jika koneksi menggunakan HTTPS)
   ```
   $config['request']['block_all_mixed_content'] 	= true;
   $config['request']['upgrade_insecure_requests'] = true;
   ```
6. Menambahkan _Content Security Policy API Reporting_ untuk pelaporan pelanggaran terhadap kebijakan konten. Sebagai contoh:
   ```
   # Untuk browser terbaru
   $config['report']['report_to_header'] = '{"group":"default","max_age":31536000,"endpoints":[{"url":"https://csp-api-report.com/"}],"include_subdomains":true}';
   
   # Untuk browser lama
   $config['report']['report_uri'] = 'https://csp-api-report.com/';
   ```
   
### Kontak dan Dukungan

Jika mengalami kesulitan dalam proses instalasi, atau menemukan bug dan celah keamanan, silakan kirimkan email beserta _screenshoot_ ke email [berikut](mailto:mrnaeem@tutanota.com).
