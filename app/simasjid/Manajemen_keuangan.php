<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_keuangan extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('keuangan_m');
	}

	public function index()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/css/timeline.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min',
			'momentjs/moment.min',
			'momentjs/moment-timezone',
			'momentjs/moment-timezone-with-data',
			'momentjs/datetime-moment',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/js/timeline.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'keuangan/kas_masuk';
		
		$this->js 		= ['halaman/manajemen_keuangan', 'halaman/kas_masuk'];
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Kas Masuk',
			'kategori' 	=> $this->keuangan_m->getKategori(),
			'daftar_kas'=> $this->keuangan_m->getKas('pemasukan'),
			'btn_add' 	=> $this->app_m->getContentMenu('input-pemasukan'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-kas'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-kas'),
			'btn_log'	=> $this->app_m->getContentMenu('log-kas')
		);

		$this->load_view();
	}

	public function kas_keluar()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/css/timeline.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min',
			'momentjs/moment.min',
			'momentjs/moment-timezone',
			'momentjs/moment-timezone-with-data',
			'momentjs/datetime-moment',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/js/timeline.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'keuangan/kas_keluar';
		
		$this->js 		= ['halaman/manajemen_keuangan', 'halaman/kas_keluar'];
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Kas Keluar',
			'kategori' 	=> $this->keuangan_m->getSaldoGroupByKategori(),
			'daftar_kas'=> $this->keuangan_m->getKas('pengeluaran'),
			'btn_add' 	=> $this->app_m->getContentMenu('input-pengeluaran'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-kas'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-kas'),
			'btn_log'	=> $this->app_m->getContentMenu('log-kas')
		);

		$this->load_view();
	}

	public function saldo_kas()
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
			'daterangepicker/daterangepicker',
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'keuangan/saldo_kas';
		
		$this->js 		= 'halaman/saldo_kas';
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Saldo Kas',
			'saldo_kas'	=> $this->keuangan_m->getSaldoKas()
		);

		$this->load_view();
	}

	public function get_kas()
	{
		$post = $this->input->post(null, TRUE);
		
		$data = (!verify($post['kode_transaksi'])) ? [] : $this->keuangan_m->getKasByKodeTransaksi($post['kode_transaksi']);
		
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	function _rules()
	{
		$rules = array(
			array(
				'field' => 'kode_transaksi',
				'label' => 'Kode Transaksi',
				'rules' => 'trim|verify_hash',
				'errors'=> [
					'verify_hash' => '{field} tidak valid.'
				]
			),
			array(
				'field' => 'date',
				'label' => 'Tanggal',
				'rules' => 'required|regex_date',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_date' => '{field} harus merupakan tanggal yang valid.'
				]
			),
			array(
				'field' => 'id_kategori',
				'label' => 'Kategori',
				'rules' => 'required|integer',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'integer' => '{field} harus merupakan angka.'
				]
			),
			array(
				'field' => 'keterangan',
				'label' => 'Keterangan',
				'rules' => 'trim|required|min_length[5]|max_length[255]|regex_match[/[a-zA-Z0-9 ()\-_%\/&.,]+$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'min_length' => '{field} harus terdiri dari 5-255 karakter.',
					'max_length' => '{field} harus terdiri dari 5-255 karakter.',
					'regex_match' => '{field} hanya boleh berisi karakter [a-zA-Z0-9 ()-_%/&.,]'
				]
			)
		);

		return $rules;
	}

	public function pemasukan()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		$this->form_validation->set_rules(
			'pemasukan',
			'Pemasukan',
			'required|numeric',
			[
				'required' => '{field} wajib diisi.',
				'numeric' => '{field} harus merupakan angka.'
			]
		);
		
		if ($this->form_validation->run() == TRUE) 
		{
			// Get Image's filename without extension
			$filename = pathinfo($_FILES['dokumentasi']['name'], PATHINFO_FILENAME);

			// Remove another character except alphanumeric, space, dash, and underscore in filename
			$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

			// Remove space in filename
			$filename = str_replace(' ', '-', $filename);

			$datedir  = explode('-', $post['date']);

			$config = array(
				'form_name' => 'dokumentasi', // Form upload's name
				'upload_path' => FCPATH . '_/uploads/dokumentasi/tmp', // Upload Directory. Default : ./uploads
				'allowed_types' => 'png|jpg|jpeg|webp', // Allowed Extension
				'max_size' => '5128', // Maximun image size. Default : 5120
				'detect_mime' => TRUE, // Detect image mime. TRUE|FALSE
				'file_ext_tolower' => TRUE, // Force extension to lower. TRUE|FALSE
				'overwrite' => TRUE, // Overwrite file. TRUE|FALSE
				'enable_salt' => TRUE, // Enable salt for image's filename. TRUE|FALSE
				'file_name' => $filename, // New Image's Filename
				'extension' => 'png', // New Imaage's Extension. Default : webp
				'quality' => '100%', // New Image's Quality. Default : 95%
				'maintain_ratio' => TRUE, // Maintain image's dimension ratio. TRUE|FALSE
				'width' => 1000, // New Image's width. Default : 800px
				'height' => 1000, // New Image's Height. Default : 600px
				'cleared_path' => FCPATH . '_/uploads/dokumentasi/'.$datedir[0].'/'.$datedir[1].'/'
			);

			// Load Library
			$this->load->library('secure_upload');

			// Send library configuration
			$this->secure_upload->initialize($config);

			// Run Library
			if($this->secure_upload->doUpload())
			{
				// Get Image(s) Data
				$dokumentasi = $this->secure_upload->data();

				$data = array(
					'kode_transaksi' => strtoupper(random_char(5)).time(),
					'id_kategori' => $post['id_kategori'],
					'user_id' => $this->session->userdata('uid'),
					'keterangan' => $post['keterangan'],
					'date' => $post['date'],
					'pemasukan' => $post['pemasukan'],
					'dokumentasi' => $dokumentasi['file_name']
				);

				$status = ($this->keuangan_m->inputDataKas($data) == true) ? 1 : 0;
				$msg 	= ($status === 1) ? 'Data berhasil ditambahkan.' : 'Data gagal ditambahkan.';
			}
			else
			{
				$msg = $this->secure_upload->show_errors();
			}
		} 
		else 
		{
			$msg  = validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function pengeluaran()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		$this->form_validation->set_rules(
				'pengeluaran',
				'Pengeluaran',
				'required|numeric|less_than_equal_to['.$post['saldo'].']',
				[
					'required' => '{field} wajib diisi.',
					'numeric' => '{field} harus merupakan angka.',
					'less_than_equal_to' => '{field} tidak boleh lebih besar dari saldo.'
				]
		);
		$this->form_validation->set_rules(
				'saldo',
				'Saldo',
				'required|numeric',
				[
					'required' => '{field} wajib diisi.',
					'numeric' => '{field} harus merupakan angka.'
				]
		);
		
		if ($this->form_validation->run() == TRUE) 
		{
			// Get Image's filename without extension
			$filename = pathinfo($_FILES['dokumentasi']['name'], PATHINFO_FILENAME);

			// Remove another character except alphanumeric, space, dash, and underscore in filename
			$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

			// Remove space in filename
			$filename = str_replace(' ', '-', $filename);

			$datedir  = explode('-', $post['date']);

			$config = array(
				'form_name' => 'dokumentasi', // Form upload's name
				'upload_path' => FCPATH . '_/uploads/dokumentasi/tmp', // Upload Directory. Default : ./uploads
				'allowed_types' => 'png|jpg|jpeg|webp', // Allowed Extension
				'max_size' => '5128', // Maximun image size. Default : 5120
				'detect_mime' => TRUE, // Detect image mime. TRUE|FALSE
				'file_ext_tolower' => TRUE, // Force extension to lower. TRUE|FALSE
				'overwrite' => TRUE, // Overwrite file. TRUE|FALSE
				'enable_salt' => TRUE, // Enable salt for image's filename. TRUE|FALSE
				'file_name' => $filename, // New Image's Filename
				'extension' => 'png', // New Imaage's Extension. Default : webp
				'quality' => '100%', // New Image's Quality. Default : 95%
				'maintain_ratio' => TRUE, // Maintain image's dimension ratio. TRUE|FALSE
				'width' => 1000, // New Image's width. Default : 800px
				'height' => 1000, // New Image's Height. Default : 600px
				'cleared_path' => FCPATH . '_/uploads/dokumentasi/'.$datedir[0].'/'.$datedir[1].'/'
			);

			// Load Library
			$this->load->library('secure_upload');

			// Send library configuration
			$this->secure_upload->initialize($config);

			// Run Library
			if($this->secure_upload->doUpload())
			{
				// Get Image(s) Data
				$dokumentasi = $this->secure_upload->data();

				$data = array(
					'kode_transaksi' => strtoupper(random_char(5)).time(),
					'id_kategori' => $post['id_kategori'],
					'user_id' => $this->session->userdata('uid'),
					'keterangan' => $post['keterangan'],
					'date' => $post['date'],
					'pengeluaran' => $post['pengeluaran'],
					'dokumentasi' => $dokumentasi['file_name']
				);

				$status = ($this->keuangan_m->inputDataKas($data) == true) ? 1 : 0;
				$msg 	= ($status === 1) ? 'Data berhasil ditambahkan.' : 'Data gagal ditambahkan.';
			}
			else
			{
				$msg = $this->secure_upload->show_errors();
			}
		} 
		else 
		{
			$msg  	= validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function edit($mode = NULL)
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());

		// Get Image's filename without extension
		$filename = pathinfo($_FILES['dokumentasi']['name'], PATHINFO_FILENAME);

		// Remove another character except alphanumeric, space, dash, and underscore in filename
		$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

		// Remove space in filename
		$filename = str_replace(' ', '-', $filename);
		
		$datedir  = explode('-', $post['date']);

		$config = array(
			'form_name' => 'dokumentasi', // Form upload's name
			'upload_path' => FCPATH . '_/uploads/dokumentasi/tmp', // Upload Directory. Default : ./uploads
			'allowed_types' => 'png|jpg|jpeg|webp', // Allowed Extension
			'max_size' => '5128', // Maximun image size. Default : 5120
			'detect_mime' => TRUE, // Detect image mime. TRUE|FALSE
			'file_ext_tolower' => TRUE, // Force extension to lower. TRUE|FALSE
			'overwrite' => TRUE, // Overwrite file. TRUE|FALSE
			'enable_salt' => TRUE, // Enable salt for image's filename. TRUE|FALSE
			'file_name' => $filename, // New Image's Filename
			'extension' => 'png', // New Imaage's Extension. Default : webp
			'quality' => '100%', // New Image's Quality. Default : 95%
			'maintain_ratio' => TRUE, // Maintain image's dimension ratio. TRUE|FALSE
			'width' => 1000, // New Image's width. Default : 800px
			'height' => 1000, // New Image's Height. Default : 600px
			'cleared_path' => FCPATH . '_/uploads/dokumentasi/'.$datedir[0].'/'.$datedir[1].'/'
		);

		// Load Library
		$this->load->library('secure_upload');

		// Send library configuration
		$this->secure_upload->initialize($config);

		// Run Library
		if($this->secure_upload->doUpload())
		{
			// Get Image(s) Data
			$dokumentasi = $this->secure_upload->data();
			$dokumentasi = $dokumentasi['file_name'];

			@unlink($config['cleared_path'].'/'.$post['dokumentasi_old']);
		}
		else
		{
			$dokumentasi = $post['dokumentasi_old'];
		}

		switch ($mode) {
			case 'masuk':
				$this->form_validation->set_rules(
					'pemasukan',
					'Pemasukan',
					'required|numeric',
					[
						'required' => '{field} wajib diisi.',
						'numeric' => '{field} harus merupakan angka.'
					]
				);
				$data = array(
					'id_kategori' => $post['id_kategori'],
					'user_id' => $this->session->userdata('uid'),
					'keterangan' => $post['keterangan'],
					'date' => $post['date'],
					'pemasukan' => $post['pemasukan'],
					'dokumentasi' => $dokumentasi
				);
				break;

			case 'keluar':
				$this->form_validation->set_rules(
					'pengeluaran',
					'Pengeluaran',
					'required|numeric|less_than_equal_to['.$post['saldo'].']',
					[
						'required' => '{field} wajib diisi.',
						'numeric' => '{field} harus merupakan angka.',
						'less_than_equal_to' => '{field} tidak boleh lebih besar dari saldo.'
					]
				);
				$this->form_validation->set_rules(
					'saldo',
					'Saldo',
					'required|numeric',
					[
						'required' => '{field} wajib diisi.',
						'numeric' => '{field} harus merupakan angka.'
					]
				);
				$data = array(
					'id_kategori' => $post['id_kategori'],
					'user_id' => $this->session->userdata('uid'),
					'keterangan' => $post['keterangan'],
					'date' => $post['date'],
					'pengeluaran' => $post['pengeluaran'],
					'dokumentasi' => $dokumentasi
				);
				break;

			default:
				show_404();
				break;
		}

		if ($this->form_validation->run() == TRUE) 
		{
			$status = ($this->keuangan_m->editKas($data, $post['kode_transaksi']) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Data berhasil diubah.' : 'Data gagal diubah.';
		} 
		else 
		{
			$msg  	= validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$post = $this->input->post(null, TRUE);
		
		if(!verify($post['kode_transaksi']))
		{
			$status = 0;
			$msg = 'Anda belum memilih data yang akan dihapus.';
		}
		else
		{
			$status = ($this->keuangan_m->hapusKas($post['kode_transaksi']) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Berhasil menghapus data.' : 'Gagal menghapus data.';
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function log()
	{
		$kode_transaksi = $this->input->post('kode_transaksi', TRUE);

		$data 	= (!verify($kode_transaksi)) ? [] : $this->keuangan_m->getLogs($kode_transaksi);

		$token 	= $this->security->get_csrf_hash();
		$result = array('log' => $data, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}