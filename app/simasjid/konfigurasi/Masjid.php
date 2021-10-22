<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masjid extends SIMASJID_Config {

	public $masjid = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->model('config_m');

		$this->masjid = $this->config_m->getMasjidSetting();

		$this->_partial = array(
			'body',
			'script'
		);
	}

	public function index()
	{	
		if(!empty($this->masjid)) redirect('konfigurasi-admin');

		$this->_module 	= 'konfigurasi/masjid';
		
		$this->js 		= 'halaman/konfigurasi_masjid';

		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Konfigurasi Masjid'
		);

		$this->load_view();
	}

	function telp_masjid($str)
	{
		if(!preg_match("/^(?:\+62|\(0\d{2,3}\)|0)\s?(?:361|8[17]\s?\d?)?(?:[ -]?\d{3,4}){2,3}$/", $str))
		{
			$this->form_validation->set_message('telp_masjid', 'Nomor telepon tidak Valid');
			return false;
		}
		else
		{
			return true;
		}
	}

	private function _rules()
	{
		$rules = array(
			array(
				'field' => 'nama_masjid',
				'label' => 'Nama Masjid',
				'rules' => 'trim|required|min_length[5]|max_length[255]|regex_match[/[a-zA-Z0-9 \-_\']+$/]',
				'errors'=> array(
					'required' => '{field} harus diisi.',
					'min_length' => 'Panjang minimal {field} {param} karakter',
					'max_length' => 'Panjang maksiml {field} {param} karakter',
					'regex_match'=> '{field} hanya  boleh mengandung alfanumerik, spasi, dan dash'
				)
			),
			array(
				'field' => 'alamat_masjid',
				'label' => 'Alamat Masjid',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z0-9 @&#\/\-_.,]+$/]|min_length[3]|max_length[500]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @&#\/\-_.,]',
					'min_length' => 'Panjang {field} minimal {param} karakater.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			),
			array(
				'field' => 'telepon_masjid',
				'label' => 'No. Telepon',
				'rules'	=> 'callback_telp_masjid',
				'errors'=> [
					'required' => '{field} harus diisi.'
				]
			),
			array(
				'field' => 'email_masjid',
				'label' => 'Email Masjid',
				'rules'	=> 'trim|required|valid_email|max_length[100]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'valid_email' => '{field} harus merupakan email yang valid.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			)
		);

		return $rules;
	}

	public function submit()
	{
		$status  = 0;
		$setting = $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());

		if ($this->form_validation->run() == TRUE) {
			
			if(!empty($_FILES['logo_masjid']['name']))
			{
				// Get Image's filename without extension
				$filename = pathinfo($_FILES['logo_masjid']['name'], PATHINFO_FILENAME);

				// Remove another character except alphanumeric, space, dash, and underscore in filename
				$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

				// Remove space in filename
				$filename = str_replace(' ', '-', $filename);

				$config = array(
					'form_name' => 'logo_masjid', // Form upload's name
					'upload_path' => FCPATH . '_/uploads', // Upload Directory. Default : ./uploads
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
					'width' => 600, // New Image's width. Default : 800px
					'height' => 600, // New Image's Height. Default : 600px
					'cleared_path' => FCPATH . '_/uploads/sites'
				);

				// Load Library
				$this->load->library('secure_upload');

				// Send library configuration
				$this->secure_upload->initialize($config);

				// Run Library
				if($this->secure_upload->doUpload())
				{
					// Get Image(s) Data
					$data_logo 	 = $this->secure_upload->data();
					$logo_masjid = $data_logo['file_name'];
				}
			}
			else
			{

				$logo_masjid = 'mosque-icon.png';
			}

			if(!empty($_FILES['icon_masjid']['name']))
			{
				// Get Image's filename without extension
				$filename = pathinfo($_FILES['icon_masjid']['name'], PATHINFO_FILENAME);

				// Remove another character except alphanumeric, space, dash, and underscore in filename
				$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

				// Remove space in filename
				$filename = str_replace(' ', '-', $filename);

				$config = array(
					'form_name' => 'icon_masjid', // Form upload's name
					'upload_path' => FCPATH . '_/uploads', // Upload Directory. Default : ./uploads
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
					'width' => 50, // New Image's width. Default : 800px
					'height' => 50, // New Image's Height. Default : 600px
					'cleared_path' => FCPATH . '_/uploads/sites'
				);

				// Load Library
				$this->load->library('secure_upload');

				// Send library configuration
				$this->secure_upload->initialize($config);

				// Run Library
				if($this->secure_upload->doUpload())
				{
					// Get Image(s) Data
					$data_icon 	 = $this->secure_upload->data();
					$icon_masjid = $data_icon['file_name'];
				}
			}
			else
			{
				$icon_masjid = 'mosque-icon.png';
			}

			$settings = array_replace($setting, array('logo_masjid' => $logo_masjid, 'icon_masjid' => $icon_masjid));

			$status = ($this->config_m->insertMasjid($settings) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Konfigurasi berhasil disimpan.' : 'Gagal menyimpan konfigurasi.';
		} 
		else 
		{
			$msg = validation_errors();
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result)); 
	}
}