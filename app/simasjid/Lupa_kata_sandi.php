<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lupa_kata_sandi extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->is_login();

		$this->load->model('lupa_kata_sandi_m');

		$this->_partial = array(
			'head',
			'body',
			'script'
		);
	}

	public function index()
	{
		$this->_module 	= 'akun/lupa_password_view';
		
		$this->js 		= 'halaman/masuk';

		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Lupa Kata Sandi'
		);

		$this->load_view();
	}

	public function submit()
	{
		$status = 0;
		$user_email  = $this->input->post('user_email', TRUE);
			
		$form_rules = [
	        ['field' => 'user_email',
	         'label' => 'User Email',
	         'rules' => 'trim|required|valid_email'
	        ]
	    ];

		$this->form_validation->set_rules($form_rules);

		if ($this->form_validation->run() == TRUE)
		{
			$token = base64url_encode(hash_hmac('sha3-256', random_char(16,true), openssl_random_pseudo_bytes(16)));

			if($this->lupa_kata_sandi_m->checkEmail($user_email) == 1) 
			{
				$this->lupa_kata_sandi_m->updateToken($user_email, $token);

				$from = $this->config->item('smtp_user');
				$this->load->library('email');
				
				$this->email->from($from, 'Sistem Informasi dan Manajemen Masjid [SIMASJID]');
				$this->email->to($user_email);
				
				$this->email->subject('PERMINTAAN ATUR ULANG KATA SANDI');
				$this->email->message("Kepada ".$user_email.", anda telah melakukan permintaan atur ulang kata sandi. Mohon klik tautan berikut untuk mengatur ulang kata sandi dan mengaktivasi kembali akun anda.\n\n".base_url('aktivasi/'.$token));
				
				$status = (!$this->email->send()) ? 0 : 1;
				$msg = ($status === 1) ? 'Tautan telah dikirim ke email anda.' : $this->email->print_debugger();
			}
			else
			{
				$msg = 'Email tidak terdaftar.';
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