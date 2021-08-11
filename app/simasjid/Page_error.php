<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_error extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();

		$this->_partial = array(
			'head',
			'body',
			'script'
		);
	}

	public function index($error = NULL)
	{	
		$this->_module 	= 'error/error';
		$heading		= $error;

		switch ($error) {
			case '403':
				$this->output->set_status_header(403);
				
				$title 			= 'Akses Ditolak';
				$color 			= 'bg-danger';
				$message 		= '\'Afwan, antum tidak diizinkan untuk mengakses halaman ini. Silakan kembali!';
				break;
			
			case '405':
				$this->output->set_status_header(405);
				
				$title 			= 'Metode tidak Diizinkan';
				$color 			= 'bg-warning';
				$message 		= '\'Antum menggunakan metode yang ilegal untuk mengakses halaman ini.<br/>Jika antum merasa ini sebuah kesalahan, cobalah untuk membersihkan cookie atau cache pada peramban antum.';
				break;

			default:
				$this->output->set_status_header(404);

				$heading		= '404';
				$title 			= 'Halaman tidak Ditemukan';
				$color 			= 'bg-primary';
				$message 		= 'Halaman yang diminta tidak tersedia atau telah dihapus.';
				break;
		}

		$this->_data 	= array(
			'title'	  => $title,
			'heading' => $heading,
			'color'   => $color,
			'message' => $message
		);

		$this->load_view();
	}
}
