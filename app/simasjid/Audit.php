<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('audit_m');
	}

	public function index()
	{
		if(isset($_POST['start']))
		{
			$start 	= strtotime($this->input->post('start', TRUE));
			$end 	= strtotime($this->input->post('end', TRUE)); 

			$data   = $this->audit_m->getLogKas($start, $end);
			$token 	= array('token' => $this->security->get_csrf_hash());
			$result = array_merge($token, $data);

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		else
		{
			$this->css_plugin = array(
				'fontawesome/css/all.min',
				'mdi/css/materialdesignicons.min',
				'datatables/datatables.min',
				'daterangepicker/daterangepicker'
			);

			$this->js_plugin = array(
				'datatables/datatables.min',
				'momentjs/moment.min',
				'momentjs/moment-timezone',
				'momentjs/moment-timezone-with-data',
				'momentjs/datetime-moment',
				'daterangepicker/daterangepicker'
			);

			$this->_partial = array(
				'head',
				'sidebar',
				'navbar',
				'body',
				'footer',
				'script'
			);

			$this->_module 	= 'audit/audit_kas_view';
			
			$this->js 		= 'halaman/audit_kas';
			
			$this->_data 	= array(
				'title' 	=> 'SIMASJID - Audit Kas'
			);

			$this->load_view();
		}
	}

	public function zakat_fitrah()
	{
		if(isset($_POST['start']))
		{
			$start 	= strtotime($this->input->post('start', TRUE));
			$end 	= strtotime($this->input->post('end', TRUE)); 

			$data   = $this->audit_m->getLogZakatFitrah($start, $end);
			$token 	= array('token' => $this->security->get_csrf_hash());
			$result = array_merge($token, $data);

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		else
		{
			$this->css_plugin = array(
				'fontawesome/css/all.min',
				'mdi/css/materialdesignicons.min',
				'datatables/datatables.min',
				'daterangepicker/daterangepicker'
			);

			$this->js_plugin = array(
				'datatables/datatables.min',
				'momentjs/moment.min',
				'momentjs/moment-timezone',
				'momentjs/moment-timezone-with-data',
				'momentjs/datetime-moment',
				'daterangepicker/daterangepicker'
			);

			$this->_partial = array(
				'head',
				'sidebar',
				'navbar',
				'body',
				'footer',
				'script'
			);

			$this->_module 	= 'audit/audit_zakat_view';
			
			$this->js 		= 'halaman/audit_zakat';

			$this->_data 	= array(
				'title' 	=> 'SIMASJID - Audit Zakat Fitrah',
				'card_title'=> 'Log Zakat Fitrah',
				'url'		=> 'audit-zakat-fitrah'
			);

			$this->load_view();
		}
	}

	public function zakat_mal()
	{
		if(isset($_POST['start']))
		{
			$start 	= strtotime($this->input->post('start', TRUE));
			$end 	= strtotime($this->input->post('end', TRUE)); 

			$data   = $this->audit_m->getLogZakatMal($start, $end);
			$token 	= array('token' => $this->security->get_csrf_hash());
			$result = array_merge($token, $data);

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		else
		{
			$this->css_plugin = array(
				'fontawesome/css/all.min',
				'mdi/css/materialdesignicons.min',
				'datatables/datatables.min',
				'daterangepicker/daterangepicker'
			);

			$this->js_plugin = array(
				'datatables/datatables.min',
				'momentjs/moment.min',
				'momentjs/moment-timezone',
				'momentjs/moment-timezone-with-data',
				'momentjs/datetime-moment',
				'daterangepicker/daterangepicker'
			);

			$this->_partial = array(
				'head',
				'sidebar',
				'navbar',
				'body',
				'footer',
				'script'
			);

			$this->_module 	= 'audit/audit_zakat_view';
			
			$this->js 		= 'halaman/audit_zakat';

			$this->_data 	= array(
				'title' 	=> 'SIMASJID - Audit Zakat Mal',
				'card_title'=> 'Log Zakat Mal',
				'url'		=> 'audit-zakat-mal'
			);

			$this->load_view();
		}
	}

	public function inventaris()
	{
		if(isset($_POST['start']))
		{
			$start 	= strtotime($this->input->post('start', TRUE));
			$end 	= strtotime($this->input->post('end', TRUE)); 

			$data   = $this->audit_m->getLogInventaris($start, $end);
			$token 	= array('token' => $this->security->get_csrf_hash());
			$result = array_merge($token, $data);

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		else
		{
			$this->css_plugin = array(
				'fontawesome/css/all.min',
				'mdi/css/materialdesignicons.min',
				'datatables/datatables.min',
				'daterangepicker/daterangepicker'
			);

			$this->js_plugin = array(
				'datatables/datatables.min',
				'momentjs/moment.min',
				'momentjs/moment-timezone',
				'momentjs/moment-timezone-with-data',
				'momentjs/datetime-moment',
				'daterangepicker/daterangepicker'
			);

			$this->_partial = array(
				'head',
				'sidebar',
				'navbar',
				'body',
				'footer',
				'script'
			);

			$this->_module 	= 'audit/audit_inventaris_view';
			
			$this->js 		= 'halaman/audit_inventaris';

			$this->_data 	= array(
				'title' 	=> 'SIMASJID - Audit Inventaris'
			);

			$this->load_view();
		}
	}
}