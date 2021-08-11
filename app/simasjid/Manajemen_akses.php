<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_akses extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();

		$this->access_control->check_login();

		$this->load->model('akses_m');
	}

	public function index()
	{
		$this->access_control->check_role();

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min'
		);

		$this->_module 	= 'akses/manajemen_akses_view';

		$this->js 		= 'halaman/akses';

		$this->_data	= array(
			'title'		=> 'SIMASJID - Manajemen Akses',
			'user_type' => $this->akses_m->getUserType(),
			'menus'		=> $this->akses_m->getMenus(),
			'btn_edit'	=> $this->app_m->getContentMenu('edit-role'),
			'btn_delete'=> $this->app_m->getContentMenu('hapus-role'),
			'btn_add'	=> $this->app_m->getContentMenu('tambah-role'),
		);

		$this->load_view();
	}

	public function get_akses()
	{
		$this->access_control->check_role();
		
		$post = $this->input->post(null, TRUE);
		
		$data = (verify($post['id']) === false) ? [] : $this->akses_m->getAksesByHash($post['id']);
		
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function tambah()
	{
		$this->access_control->check_role();

		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('type_code', 'Tipe Akses', 'trim|required|regex_match[/^[a-zA-Z ]+$/]|min_length[1]|max_length[100]|is_unique[tb_user_type.type_name]');
		$this->form_validation->set_rules('menu_id[]', 'Role', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{		
			$status = ($this->akses_m->tambahAkses($post) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Tipe akses ditambahkan.' : 'Gagal menambahkan tipe akses.';
		}
		else
		{
			$msg = validation_errors();
		}
		
		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function edit()
	{
		$this->access_control->check_role();

		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules('type_id', 'ID Tipe', 'trim|required|verify_hash');
		$this->form_validation->set_rules('type_code', 'Tipe Akses', 'trim|required|regex_match[/^[a-zA-Z ]+$/]|min_length[1]|max_length[100]');
		$this->form_validation->set_rules('menu_id[]', 'Role', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{	
			if($this->akses_m->cekAkses($post['type_code'], $post['type_id']) == 0)
			{	
				$status = ($this->akses_m->editAkses($post) == true) ? 1 : 0;
				$msg 	= ($status === 1) ? 'Berhasil merubah tipe akses.' : 'Gagal merubah tipe akses.';

				$this->cache->clean();
			}
			else
			{
				$msg = 'Akses tipe sudah ada.';
			}
		}
		else
		{
			$msg = validation_errors();
		}
		
		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$this->access_control->check_role();

		$post = $this->input->post(null, TRUE);
		
		if( ! verify($post['id']) )
		{
			$status = 0;
			$msg = 'Pilih tipe akses yang akan dihapus!';
		}
		else
		{
			$status = ($this->akses_m->hapusAkses($post['id']) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Berhasil menghapus tipe akses.' : 'Gagal menghapus tipe akses.';
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update_index()
	{
		$data 	= $this->input->post(null, TRUE);
		$status = 0;

		if(verify($data['id']) !== FALSE) 
		{
			$this->form_validation->set_rules('index_page', 'Index', 'trim|required|regex_match[/[a-z\-]+$/]');
			if ($this->form_validation->run() == TRUE) 
			{
				$status = ($this->akses_m->updateIndex($data) === TRUE) ? 1 : 0;
			}
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}