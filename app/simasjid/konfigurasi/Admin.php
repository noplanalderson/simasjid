<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends SIMASJID_Config {

	public $admin = array();

	public $masjid = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->model('config_m');

		$this->masjid 	= $this->config_m->getMasjidSetting();
		$this->admin 	= $this->config_m->getAdmin();

		$this->_partial = array(
			'body',
			'script'
		);
	}

	public function index()
	{	
		if(empty($this->masjid)) redirect('konfigurasi-masjid');

		if(!empty($this->admin)) redirect('konfigurasi-smtp');

		$this->_module 	= 'konfigurasi/admin';
		
		$this->js 		= 'halaman/konfigurasi_admin';

		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Konfigurasi Admin'
		);

		$this->load_view();
	}

	public function submit()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			$password = passwordHash($post['user_password'], 
				array(
					'memory_cost' => 2048, 
					'time_cost' => 4, 
					'threads' => 1
				)
			);

			$adminSetting = array(
				'user_name' => strtolower($post['user_name']),
				'user_password' => $password,
				'real_name' => ucwords($post['real_name']),
				'user_email' => strtolower($post['user_email']),
				'id_jabatan' => 1,
				'user_picture' => 'user.jpg',
				'is_active' => 1
			);

			$user = $this->config_m->tambahAdmin($adminSetting);
			
			$status = ($user !== false) ? 1 : 0;

			if($status !== 0) {

				$userDir 	= FCPATH . '_/uploads/users/'.encrypt($user).'/';
				$assetDir 	= FCPATH . '_/uploads/users/';

				if (!is_dir($userDir)) mkdir($userDir, 0755, true);

				copy($assetDir . 'user.jpg', $userDir . 'user.jpg');
			}

			$msg = ($status === 1) ? 'User admin berhasil ditambahkan.' : 'User admin gagal ditambahkan.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	private function rules()
	{
		$rules = array(
			array(
				'field' => 'user_name',
				'label' => 'Username',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z0-9_]+$/]|min_length[3]|max_length[100]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumeric dan underscore.',
					'min_length' => 'Panjang {field} minimal {param} karakater.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			),
			array(
				'field' => 'user_email',
				'label' => 'Email',
				'rules'	=> 'trim|required|valid_email|max_length[100]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumeric dan underscore.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			),
			array(
				'field' => 'user_password',
		        'label' => 'Password',
		        'rules' => 'regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/]|required',
		        'errors'=> array('required' => '{field} harus diisi.',
                    'regex_match' => '{field} harus terdiri dari Uppercase, Lowercase, Numerik, dan Simbol 8-16 karakter.'
                )
			),
			array(
				'field' => 'repeat_password',
		        'label' => 'Repeat Password',
		        'rules' => 'required|matches[user_password]',
		        'errors'=> array(
		        	'required' => '{field} harus diisi.',
                    'matches' => '{field} tidak cocok.'
                )
			),
			array(
				'field' => 'real_name',
				'label' => 'Nama Admin',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z .,]+$/]|max_length[255]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung huruf, spasi, titik, dan koma.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			),
		);

		return $rules;
	}
}