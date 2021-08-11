<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluar extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('masuk_m');
	}
	
	public function index()
	{
		$this->load->model('masuk_m');
		$this->cache->clean();
		
		$this->masuk_m->update_login_data();
		
		$session = array('uid', 'gid', 'time');
		$this->session->unset_userdata($session);
		redirect('masuk');
	}

}

/* End of file keluar.php */
/* Location: ./application/controllers/keluar.php */