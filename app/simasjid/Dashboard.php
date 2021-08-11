<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();

		$this->load->model('dashboard_m');
	}

	public function index()
	{
		$this->access_control->check_role();

		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min'
		);

		$this->js_plugin = array(
			'chart.js/Chart.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'dashboard/dashboard_view';
		
		$this->js 		= 'halaman/dashboard';

		$this->_data 	= array(
			'title' 			=> 'SIMASJID - Dashboard',
			'kas_masjid' 		=> $this->dashboard_m->getKasMasjid(),
			'zakat_fitrah'		=> $this->dashboard_m->getZakatFitrahUang(),
			'zakat_mal'			=> $this->dashboard_m->getZakatMalUang(),
			'transaksi_terakhir'=> $this->dashboard_m->transaksiTerakhir(),
			'agenda_hari_ini'	=> $this->dashboard_m->getAgendaToday(),
			'inventaris'		=> $this->dashboard_m->getStokBarang()
		);

		$this->load_view();
	}

	public function get_sumber_kas()
	{
		$result = $this->dashboard_m->chartKas();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}