<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/*----------------------------------
| Route for App Configuration Module
|-----------------------------------
|
*/
$route['konfigurasi-masjid'] 		= 'konfigurasi/masjid/index';
$route['submit-masjid'] 			= 'konfigurasi/masjid/submit';
$route['konfigurasi-admin']			= 'konfigurasi/admin/index';
$route['submit-admin']				= 'konfigurasi/admin/submit';
$route['konfigurasi-smtp'] 			= 'konfigurasi/smtp/index';
$route['submit-smtp'] 				= 'konfigurasi/smtp/submit';

/*----------------------------------
| Route for Account Management Module
|-----------------------------------
|
*/
$route['default_controller'] 		= 'masuk';
$route['aktivasi/(:any)'] 			= 'aktivasi/index/$1';
$route['do-aktivasi'] 				= 'aktivasi/submit';

/*----------------------------------
| Route for Access Management Module
|-----------------------------------
|
*/
$route['get-role']					= 'manajemen_akses/get_akses';
$route['tambah-role']				= 'manajemen_akses/tambah';
$route['edit-role']					= 'manajemen_akses/edit';
$route['hapus-role']				= 'manajemen_akses/hapus';
$route['update-index']				= 'manajemen_akses/update_index';

/*----------------------------------
| Route for User Management Module
|-----------------------------------
|
*/
$route['get-user']					= 'manajemen_user/get_user';
$route['tambah-user']				= 'manajemen_user/tambah';
$route['edit-user']					= 'manajemen_user/edit';
$route['hapus-user']				= 'manajemen_user/hapus';

/*----------------------------------
| Route for Utilities Module
|-----------------------------------
|
*/
$route['get-utilitas/(:any)']		= 'utilitas/get_utilitas/$1';
$route['tambah-utilitas/(:any)']	= 'utilitas/tambah/$1';
$route['edit-utilitas/(:any)']		= 'utilitas/edit/$1';
$route['hapus-utilitas/(:any)']		= 'utilitas/hapus/$1';

/*----------------------------------
| Route for Cash Management Module
|-----------------------------------
|
*/
$route['kas-masuk']					= 'manajemen_keuangan/index';
$route['kas-keluar']				= 'manajemen_keuangan/kas_keluar';
$route['saldo-kas']					= 'manajemen_keuangan/saldo_kas';
$route['input-pemasukan']			= 'manajemen_keuangan/pemasukan';
$route['input-pengeluaran']			= 'manajemen_keuangan/pengeluaran';
$route['get-kas']					= 'manajemen_keuangan/get_kas';
$route['edit-kas/([a-z]+)']			= 'manajemen_keuangan/edit/$1';
$route['hapus-kas']					= 'manajemen_keuangan/hapus';
$route['log-kas']					= 'manajemen_keuangan/log';

/*----------------------------------
| Route for Zakat Fitrah Management Module
|-----------------------------------
|
*/
$route['data-muzakki']					= 'zakat_fitrah/index';
$route['data-mustahik']					= 'zakat_fitrah/mustahik';
$route['get-zakat-fitrah']				= 'zakat_fitrah/get_zakat';
$route['tambah-zakat-fitrah']			= 'zakat_fitrah/tambah';
$route['edit-zakat-fitrah']				= 'zakat_fitrah/edit';
$route['hapus-zakat-fitrah']			= 'zakat_fitrah/hapus';
$route['log-zakat-fitrah']				= 'zakat_fitrah/log';
$route['kwitansi-zakat-fitrah/(:any)']	= 'zakat_fitrah/kwitansi/$1';
$route['rekapitulasi-zakat-fitrah'] 	= 'zakat_fitrah/rekapitulasi';

/*----------------------------------
| Route for Zakat Mal Management Module
|-----------------------------------
|
*/
$route['zakat-mal-masuk']			= 'zakat_mal/index';
$route['zakat-mal-keluar']			= 'zakat_mal/mustahik';
$route['get-zakat-mal']				= 'zakat_mal/get_zakat';
$route['tambah-zakat-mal']			= 'zakat_mal/tambah';
$route['edit-zakat-mal']			= 'zakat_mal/edit';
$route['hapus-zakat-mal']			= 'zakat_mal/hapus';
$route['log-zakat-mal']				= 'zakat_mal/log';
$route['kwitansi-zakat-mal/(:any)']	= 'zakat_mal/kwitansi/$1';
$route['rekap-zakat-mal'] 			= 'zakat_mal/rekapitulasi';

/*----------------------------------
| Route for Agenda Kegiatan Module
|-----------------------------------
|
*/
$route['kalender']					= 'agenda_kegiatan/kalender';
$route['data-kalender']				= 'agenda_kegiatan/data_kalender';
$route['tambah-agenda']				= 'agenda_kegiatan/tambah';
$route['get-agenda']				= 'agenda_kegiatan/get';
$route['edit-agenda']				= 'agenda_kegiatan/edit';
$route['hapus-agenda']				= 'agenda_kegiatan/hapus';

/*----------------------------------
| Route for Inventarisasi Module
|-----------------------------------
|
*/
$route['barang-masuk']				= 'inventarisasi/index';
$route['barang-keluar']				= 'inventarisasi/barang_keluar';
$route['stok-barang']				= 'inventarisasi/stok_barang';
$route['input-barang-masuk']		= 'inventarisasi/input_barang_masuk';
$route['input-barang-keluar']		= 'inventarisasi/input_barang_keluar';
$route['get-barang']				= 'inventarisasi/get_barang';
$route['edit-barang/([a-z]+)']		= 'inventarisasi/edit/$1';
$route['hapus-barang']				= 'inventarisasi/hapus';
$route['log-barang']				= 'inventarisasi/log';

/*----------------------------------
| Route for Kalkulator Zakat Module
|-----------------------------------
|
*/
$route['kal-zakat-penghasilan'] 	= 'kalkulator_zakat/index';
$route['kal-zakat-mal'] 			= 'kalkulator_zakat/mal';

/*----------------------------------
| Route for Pemberitahuan dan Memo Module
|-----------------------------------
|
*/
$route['buat-memo'] 					= 'memo/index';
$route['baca-notif'] 					= 'memo/baca';
$route['tandai-dibaca'] 				= 'memo/terbaca';
$route['pemberitahuan-terbaru'] 		= 'memo/pemberitahuan_terbaru';
$route['memo-masuk'] 					= 'memo/masuk';
$route['memo-keluar']					= 'memo/keluar';
$route['get-memo-dari']					= 'memo/dari';
$route['get-memo-kepada']				= 'memo/kepada';
$route['hapus-memo-masuk']				= 'memo/hapus_memo_masuk';
$route['hapus-semua-dari']				= 'memo/hapus_semua_dari';
$route['hapus-memo-keluar']				= 'memo/hapus_memo_keluar';
$route['hapus-semua-kepada']			= 'memo/hapus_semua_kepada';
$route['trash'] 						= 'memo/trash';
$route['get-trash/([a-z]+)']			= 'memo/get_trash/$1';
$route['hapus-memo-permanen/([a-z]+)']	= 'memo/hapus_permanen/$1';
$route['kosongkan-trash/([a-z]+)']		= 'memo/kosongkan_trash/$1';
$route['pulihkan/([a-z]+)']				= 'memo/pulihkan/$1';

/*----------------------------------
| Route for Database Mustahik Module
|-----------------------------------
|
*/
$route['get-data-mustahik']			= 'database_mustahik/get';
$route['tambah-data-mustahik']		= 'database_mustahik/tambah';
$route['edit-data-mustahik']		= 'database_mustahik/edit';
$route['hapus-data-mustahik']		= 'database_mustahik/hapus';

/*----------------------------------
| Route for Auditor Module
|-----------------------------------
|
*/
$route['audit-kas']					= 'audit/index';
$route['audit-zakat-fitrah']		= 'audit/zakat_fitrah';
$route['audit-zakat-mal']			= 'audit/zakat_mal';
$route['audit-inventaris']			= 'audit/inventaris';

/*----------------------------------
| Route for Dokumentasi Module
|-----------------------------------
|
*/
$route['unggah-foto'] 				= 'dokumentasi/unggah_foto';
$route['get-foto'] 					= 'dokumentasi/get';
$route['hapus-foto'] 				= 'dokumentasi/hapus';

/*----------------------------------
| Other Settings
|-----------------------------------
|
*/
$route['page-error/(:any)'] 		= 'page_error/index/$1';
$route['404_override'] 				= 'page_error/index';
$route['translate_uri_dashes'] 		= TRUE;
