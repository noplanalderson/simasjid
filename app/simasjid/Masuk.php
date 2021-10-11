<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk extends SIMASJID_Core {

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

	public function index()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min'
		);
		
		$this->_module 	= 'akun/masuk_view';
		
		$this->js 		= 'halaman/masuk';

		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Masuk'
		);

		$this->load_view();
	}

	public function auth()
	{
		$status 		= 0;
		$user 			= [];

		$user_name 		= $this->input->post('user_name', TRUE);
		$user_password	= $this->input->post('user_password', TRUE);

		$form_rules = [
	        ['field' => 'user_name',
	         'label' => 'User Name',
	         'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9@\-_.]+$/]',
	         'errors'=> array('required' => '{field} required', 
	                    'regex_match' => '{field} only allowed alfa numeric, dash, @, and underscore')
	        ],
	        ['field' => 'user_password',
	         'label' => 'Password',
	         'rules' => 'trim|required',
	         'errors'=> array('required' => '{field} required')
	        ]
	    ];

		$this->form_validation->set_rules($form_rules);

		if ($this->form_validation->run() == TRUE)
		{
			$userData =  $this->masuk_m->verify($user_name);

			if($userData->num_rows() == 1) 
			{
				$user = $userData->row_array();

				$status = (password_verify($user_password, $user['user_password']) == true) ? 1 : 0;
		
				if($status === 1)
				{
					$now = new DateTime();
					$now->setTimezone(new DateTimeZone('Asia/Jakarta'));

					$index_page = $user['index_page'];

					$sessionLogin = array(  
						'uid' 	=> $user['user_id'],
						'gid' 	=> $user['type_id'],
						'time'	=> strtotime($now->format('Y-m-d H:i:s')),
					);

					$this->session->set_userdata($sessionLogin);
					
					$msg = 'Login berhasil. Mohon tunggu... ';
				}
				else
				{
					$msg = 'Login gagal. Password salah!';
				}
			}
			else
			{
				$msg = 'Login gagal. Username atau email tidak ditemukan!';
			}
		}
		else
		{
			$msg = validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token, 'url' => empty($user) ? '' : $user['index_page']);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

}

/* End of file masuk.php */
/* Location: ./application/controllers/masuk.php */