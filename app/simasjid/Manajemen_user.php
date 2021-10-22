<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_user extends SIMASJID_Core {

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
			'mdi/css/materialdesignicons.min',
			'select2/select2.min',
			'datatables/datatables.min'
		);

		$this->js_plugin = array(
			'select2/select2.min',
			'datatables/datatables.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'user/manajemen_user_view';
		
		$this->js 		= 'halaman/user';
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Manajemen User',
			'users' 	=> $this->user_m->getAllUsers(),
			'jabatan' 	=> $this->user_m->getJabatan(),
			'btn_add' 	=> $this->app_m->getContentMenu('tambah-user'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-user'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-user'),
			'btn_status'=> $this->app_m->getContentMenu('status-user')
		);

		$this->load_view();
	}
	
	public function get_user()
	{
		$post 	= $this->input->post(null, TRUE);
		
		$data 	= ( ! verify($post['id'])) ? [] : $this->user_m->getUserByID($post['id']);
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result	= array_merge($token, $data);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function tambah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->rules());
		
		if ($this->form_validation->run() == TRUE) 
		{	
			if($this->user_m->checkUser($post['user_name'], $post['user_email'], 'tambah') == 0)
			{
				$pwd = passwordHash($post['user_password'], 
					[
						'memory_cost' => 2048, 
						'time_cost' => 4, 
						'threads' => 1
					]
				);

				$userSetting = array(
					'user_name' => $post['user_name'],
					'user_password' => $pwd,
					'real_name' => ucwords($post['real_name']),
					'user_email' => strtolower($post['user_email']),
					'id_jabatan' => $post['id_jabatan'],
					'user_token' => base64url_encode(openssl_random_pseudo_bytes(64)),
					'user_picture' => 'user.jpg',
					'is_active' => $post['is_active']
				);

				$user = $this->user_m->tambahUser($userSetting);
				
				$status = ($user !== false) ? 1 : 0;

				if($status !== 0) {

					$userDir 	= FCPATH . '_/uploads/users/'.encrypt($user).'/';
					$assetDir 	= FCPATH . '_/uploads/users/';

					if (!is_dir($userDir)) mkdir($userDir, 0755, true);

					copy($assetDir . 'user.jpg', $userDir . 'user.jpg');

					$from = $this->config->item('smtp_user');
					$this->load->library('email');
					
					$this->email->from($from, 'Sistem Informasi dan Manajemen Masjid [SIMASJID]');
					$this->email->to($userSetting['user_email']);
					
					$this->email->subject('SIMASJID - Aktivasi Akun');
					$this->email->message("Email anda telah terdaftar pada Aplikasi SIMASJID " . $this->app->nama_masjid);
					
					$emailMsg = (!$this->email->send()) ? 'Gagal mengirim email.' : '';
				}

				$msg = ($status === 1) ? 'User berhasil ditambahkan.<br/>'.$emailMsg : 'User gagal ditambahkan.';
			}
			else
			{
				$msg = 'User sudah Terdaftar';
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

	private function rules()
	{
		$rules = array(
			array(
				'field' => 'user_id',
				'label' => 'ID User',
				'rules' => 'trim|verify_hash',
				'errors'=> [
					'verify_hash' => '{field} tidak valid.'
				]
			),
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
				'field' => 'real_name',
				'label' => 'Nama Petugas',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z .,]+$/]|max_length[255]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung huruf, spasi, titik, dan koma.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			),
			array(
				'field' => 'id_jabatan',
				'label' => 'Jabatan',
				'rules' => 'required|integer|max_length[3]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'integer' => '{field} harus integer.',
					'max_length' => 'Panjang {field} maksimal {param} karakter.'
				]
			),
			array(
				'field' => 'is_active',
				'label' => 'Status User',
				'rules' => 'regex_match[/(1|0)$/]',
				'errors'=> [
					'regex_match' => '{field} harus bernilai TRUE atau FALSE.'
				]
			),
			array(
				'field' => 'user_password',
		        'label' => 'Password',
		        'rules' => 'regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/]|required',
		        'errors'=> array('required' => '{field} required',
                    'regex_match' => '{field} harus terdiri dari Uppercase, Lowercase, Numerik, dan Simbol 8-16 karakter.'
                )
			),
			array(
				'field' => 'repeat_password',
		        'label' => 'Repeat Password',
		        'rules' => 'required|matches[user_password]',
		        'errors'=> array(
		        	'required' => '{field} required',
                    'matches' => '{field} tidak cocok.'
                )
			)
		);

		return $rules;
	}

	public function edit()
	{
		$status = 0;
		
		if(isset($_POST['user_name']))
		{
			$post = $this->input->post(null, TRUE);

			$user = $this->user_m->getUserByID($post['id_user']);

			if(empty($user)) 
			{
				$msg = 'User tidak Ditemukan.';
			}
			else
			{
				$this->form_validation->set_rules($this->rules());
				
				if ($this->form_validation->run() == TRUE) 
				{	
					if($this->user_m->checkUser($post['user_name'], $post['user_email'], 'edit', $post['id_user']) == 0)
					{
						$pwd = passwordHash($post['user_password'], 
							[
								'memory_cost' => 2048, 
								'time_cost' => 4, 
								'threads' => 1
							]
						);

						$userSetting = array(
							'user_name' => $post['user_name'],
							'real_name' => ucwords($post['real_name']),
							'user_email' => strtolower($post['user_email']),
							'user_password' => $pwd,
							'id_jabatan' => $post['id_jabatan'],
							'is_active' => $post['is_active']
						);

						$status = ($this->user_m->editUser($userSetting, $post['id_user']) === true) ? 1 : 0;
						$msg 	= ($status === 1) ? 'User berhasil diubah.' : 'User gagal diubah.';
					}
					else
					{
						$msg = 'User sudah Terdaftar';
					}
				} 
				else 
				{
					$msg = validation_errors();
				}
			}
		}
		else
		{
			$msg = 'Method not Allowed.';
		}


		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$status = false;
		$hash = $this->input->post('id', TRUE);
		
		if( ! verify($hash) )
		{
			$msg = 'User tidak ditemukan.';
		}
		else
		{
			$status  = ($this->user_m->hapusUser($hash) == true) ? remove_dir('./_/uploads/users/'.$hash) : false;
			$msg = ($status === true) ? 'User Berhasil Dihapus.' : 'Gagal Menghapus User.';
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */