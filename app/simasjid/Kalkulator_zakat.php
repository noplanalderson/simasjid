<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kalkulator_zakat extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();
	}

	public function index()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'kalkulator/kalkulator_1_view';
		
		$this->js 		= ['imask','halaman/kalkulator_1'];
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Kalkulator Zakat Penghasilan'
		);

		$this->load_view();
	}

	public function mal()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'kalkulator/kalkulator_2_view';
		
		$this->js 		= ['imask','halaman/kalkulator_2'];
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Kalkulator Zakat Mal'
		);

		$this->load_view();
	}
}