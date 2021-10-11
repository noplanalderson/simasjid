<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kalkulator_zakat_publik extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();

		$this->_partial = array(
			'head',
			'body',
			'script'
		);
	}

	public function index()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min'
		);
		
		$this->_module 	= 'kalkulator/kalkulator_publik_view';
		
		$this->js 		= ['imask','halaman/Kalkulator_zakat_publik'];
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Kalkulator Zakat'
		);

		$this->load_view();
	}
}