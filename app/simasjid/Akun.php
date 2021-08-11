<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('akun_m');
	}

	public function index()
	{
		$result = $this->akun_m->getAkun();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	private function _rulesPassword()
	{
		$rules = array(
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

	private function _rulesAkun()
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
				'field' => 'real_name',
				'label' => 'Nama Petugas',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z .,]+$/]|max_length[255]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung huruf, spasi, titik, dan koma.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			)
		);

		return $rules;
	}

	public function update()
	{
		$status = 0;
		$msg 	= [];
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rulesAkun());

		if ($this->form_validation->run() == TRUE) 
		{
			// Get Image's filename without extension
			$filename = pathinfo($_FILES['user_picture']['name'], PATHINFO_FILENAME);

			// Remove another character except alphanumeric, space, dash, and underscore in filename
			$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

			// Remove space in filename
			$filename = str_replace(' ', '-', $filename);

			$config = array(
				'form_name' => 'user_picture', // Form upload's name
				'upload_path' => FCPATH . '_/uploads/users', // Upload Directory. Default : ./uploads
				'allowed_types' => 'png|jpg|jpeg|webp', // Allowed Extension
				'max_size' => '5128', // Maximun image size. Default : 5120
				'detect_mime' => TRUE, // Detect image mime. TRUE|FALSE
				'file_ext_tolower' => TRUE, // Force extension to lower. TRUE|FALSE
				'overwrite' => TRUE, // Overwrite file. TRUE|FALSE
				'enable_salt' => TRUE, // Enable salt for image's filename. TRUE|FALSE
				'file_name' => $filename, // New Image's Filename
				'extension' => 'webp', // New Imaage's Extension. Default : webp
				'quality' => '100%', // New Image's Quality. Default : 95%
				'maintain_ratio' => TRUE, // Maintain image's dimension ratio. TRUE|FALSE
				'width' => 500, // New Image's width. Default : 800px
				'height' => 500, // New Image's Height. Default : 600px
				'cleared_path' => FCPATH . '_/uploads/users/'.encrypt($this->session->userdata('uid'))
			);

			// Load Library
			$this->load->library('secure_upload');

			// Send library configuration
			$this->secure_upload->initialize($config);

			// Run Library
			if($this->secure_upload->doUpload())
			{
				// Get Image(s) Data
				$picture = $this->secure_upload->data();
				$user_picture = $picture['file_name'];
			}
			else
			{
				$msg[] = $this->secure_upload->show_errors();
				$user_picture = $this->user->user_picture;
			}

			$akun = array(
				'user_name'   => strtolower($post['user_name']),
				'real_name'   => ucwords($post['real_name']),
				'user_email'  => strtolower($post['user_email']),
				'user_picture'=> $user_picture 
			);

			$status = ($this->akun_m->updateAkun($akun) == true) ? 1 : 0;
			$msg[] 	= ($status === 1) ? 'Profil berhasil diubah.' : 'Gagal mengubah profil.';

			if($status === 1) $this->cache->delete('simasjid_user_'.$this->user_hash);
		} 
		else 
		{
			$msg[] 	= validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => implode('<br/>', $msg), 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function ganti_kata_sandi()
	{
		$status 	= 0;
		$password 	= $this->input->post('user_password', TRUE);

		$this->form_validation->set_rules($this->_rulesPassword());

		if ($this->form_validation->run() == TRUE)
		{		
			$pwd = passwordHash($password, 
				[
					'memory_cost' => 2048, 
					'time_cost' => 4, 
					'threads' => 1
				]
			);

			$status = ($this->akun_m->ubahPassword($pwd) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Password berhasil diubah.' : 'Gagal mengubah password.';
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