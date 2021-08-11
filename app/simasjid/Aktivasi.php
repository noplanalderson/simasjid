<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivasi extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->is_login();

		$this->load->model('masuk_m');

		$this->_partial = array(
			'head',
			'body',
			'script'
		);
	}

	public function index($token = NULL)
	{
		$this->_module 	= 'akun/reset_password_view';
		
		$this->js 		= 'halaman/masuk';

		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Atur Ulang Kata Sandi',
			'token'  	=> $token
		);

		$this->load_view();
	}

	public function submit()
	{	
		$status 	= 0;
		$user_token = $this->input->post('user_token', TRUE);
		$password 	= $this->input->post('user_password', TRUE);
		
		$form_rules = [
	       	array(
				'field' => 'user_token',
				'label' => 'Token',
				'rules' => 'required|regex_match[/^[a-zA-Z0-9\-_+]+$/]',
				'errors'=> array(
					'required' => '{field} required.',
					'regex_match' => 'Allowed charcter for {field} are [a-zA-Z0-9\-_+].'
				)
			),
	       	array(
				'field' => 'user_password',
				'label' => 'Password',
				'rules' => 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,32}$/]',
				'errors'=> array(
					'required' => '{field} required.',
					'regex_match' => '{field} must contain Uppercase, Lowercase, Numeric, and Symbol min. 8 characters.'
				)
			),
			array(
				'field' => 'repeat_password',
				'label' => 'Repeat Password',
				'rules' => 'required|matches[user_password]',
				'errors'=> array(
					'required' => '{field} required.',
					'matches' => '{field} not match.' 
				)
			),
	    ];

		$this->form_validation->set_rules($form_rules);

		if ($this->form_validation->run() == TRUE)
		{
			$pwd = passwordHash($password, 
				[
					'memory_cost' => 2048, 
					'time_cost' => 4, 
					'threads' => 1
				]
			);

			$account = array(
				"user_password" => $pwd,
				"user_token" => NULL,
				"is_active" => 1
			);

			if($this->masuk_m->getUserByToken($user_token) == 1)
			{
				$status = ($this->masuk_m->doActivation($account, $user_token) === true) ? 1 : 0;

				$msg = ($status === 1) ? 'Akun anda berhasil diaktifkan. Mohon tunggu... ' : 'Gagal mengaktivasi akun anda.';
			}
			else
			{
				$msg = 'Akun tidak ditemukan.';
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
}

/* End of file masuk.php */
/* Location: ./application/controllers/masuk.php */