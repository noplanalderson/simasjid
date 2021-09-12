<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventarisasi extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('inventarisasi_m');
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

		$this->_module 	= 'inventaris/barang_masuk';
		
		$this->js 		= ['halaman/inventaris', 'halaman/barang_masuk'];
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Barang Masuk',
			'barang'	=> $this->inventarisasi_m->getBarang('masuk'),
			'saldo_kas' => $this->keuangan_m->getSaldoGroupByKategori(),
			'btn_add' 	=> $this->app_m->getContentMenu('input-barang-masuk'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-barang'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-barang'),
			'btn_log'	=> $this->app_m->getContentMenu('log-barang')
		);

		$this->load_view();
	}

	public function barang_keluar()
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

		$this->_module 	= 'inventaris/barang_keluar';
		
		$this->js 		= ['halaman/inventaris', 'halaman/barang_keluar'];
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Barang Keluar',
			'barang'	=> $this->inventarisasi_m->getBarang('keluar'),
			'stok_list'	=> $this->inventarisasi_m->getStokGroupByBarang(),
			'btn_add' 	=> $this->app_m->getContentMenu('input-barang-keluar'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-barang'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-barang'),
			'btn_log'	=> $this->app_m->getContentMenu('log-barang')
		);

		$this->load_view();
	}

	public function stok_barang()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min'
		);

		$this->js_plugin = array(
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

		$this->_module 	= 'inventaris/stok_barang';
		
		$this->js 		= 'halaman/stok_barang';
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Stok Barang',
			'stok_brg'	=> $this->inventarisasi_m->getStokBarang()
		);

		$this->load_view();
	}

	public function get_barang()
	{
		$post = $this->input->post(null, TRUE);
		
		$data = (!verify($post['kode_barang'])) ? [] : $this->inventarisasi_m->getBarangByID($post['kode_barang']);
		
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	function _rules()
	{
		$rules = array(
			array(
				'field' => 'hash',
				'label' => 'Hash Barang',
				'rules' => 'trim|verify_hash',
				'errors'=> [
					'verify_hash' => '{field} tidak valid.'
				]
			),
			array(
				'field' => 'tgl_pendataan',
				'label' => 'Tanggal',
				'rules' => 'required|regex_date',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_date' => '{field} harus merupakan tanggal yang valid.'
				]
			),
			array(
				'field' => 'nama_barang',
				'label' => 'Nama Barang',
				'rules' => 'trim|required|min_length[3]|max_length[255]|regex_match[/[a-zA-Z0-9 ()\-_%\/&.,]+$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'min_length' => '{field} harus terdiri dari 5-255 karakter.',
					'max_length' => '{field} harus terdiri dari 5-255 karakter.',
					'regex_match' => '{field} hanya boleh berisi karakter [a-zA-Z0-9 ()-_%/&.,]'
				]
			),
			array(
				'field' => 'keterangan',
				'label' => 'Keterangan',
				'rules' => 'trim|min_length[5]|max_length[255]|regex_match[/[a-zA-Z0-9 ()\-_%\/&.,]+$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'min_length' => '{field} harus terdiri dari 5-255 karakter.',
					'max_length' => '{field} harus terdiri dari 5-255 karakter.',
					'regex_match' => '{field} hanya boleh berisi karakter [a-zA-Z0-9 ()-_%/&.,]'
				]
			),
			array(
				'field' => 'satuan',
				'label' => 'Satuan',
				'rules' => 'trim|required|max_length[80]|alpha_numeric_spaces',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'max_length' => '{field} maksimal 80 karakter.',
					'alpha_numeric_spaces' => '{field} hanya boleh mengandung alfanumerik dan spasi.'
				]
			)
		);

		return $rules;
	}

	public function input_barang_masuk()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		$this->form_validation->set_rules(
			'kuantitas_masuk',
			'Kuantitas Masuk',
			'required|numeric',
			[
				'required' => '{field} wajib diisi.',
				'numeric' => '{field} harus merupakan angka.'
			]
		);
		$this->form_validation->set_rules(
				'id_kategori',
				'Kategori',
				'integer',
				[
					'integer' => '{field} harus merupakan angka.'
				]
		);
		$this->form_validation->set_rules(
				'pengeluaran',
				'Pengeluaran',
				'numeric|less_than_equal_to['.$post['saldo'].']',
				[
					'required' => '{field} wajib diisi.',
					'numeric' => '{field} harus merupakan angka.',
					'less_than_equal_to' => '{field} tidak boleh lebih besar dari saldo.'
				]
		);
		$this->form_validation->set_rules(
				'saldo',
				'Saldo',
				'numeric',
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

			$datedir  = explode('-', $post['tgl_pendataan']);

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

				$kode = strtoupper(random_char(5)).time();

				$data = array(
					'kode_barang' => $kode,
					'nama_barang' => ucwords($post['nama_barang']),
					'user_id' => $this->session->userdata('uid'),
					'keterangan' => $post['keterangan'],
					'tgl_pendataan' => $post['tgl_pendataan'],
					'kuantitas_masuk' => $post['kuantitas_masuk'],
					'kuantitas_keluar' => 0,
					'satuan' => strtoupper($post['satuan']),
					'dokumentasi' => $dokumentasi['file_name']
				);

				$dataKas = array(
					'kode_transaksi' => $kode,
					'id_kategori' => $post['id_kategori'],
					'user_id' => $this->session->userdata('uid'),
					'keterangan' => $post['keterangan'],
					'date' => $post['tgl_pendataan'],
					'pengeluaran' => $post['pengeluaran'],
					'dokumentasi' => $dokumentasi['file_name']
				);

				$status = ($this->inventarisasi_m->inputDataBarang($data) == true) ? 1 : 0;
				if($status === 1 && !empty($post['id_kategori'])) $this->keuangan_m->inputDataKas($dataKas);
				$msg 	= ($status === 1) ? 'Data berhasil ditambahkan.' : 'Data gagal ditambahkan.';
			}
			else
			{
				$msg 	= $this->secure_upload->show_errors();
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

	public function input_barang_keluar()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		$this->form_validation->set_rules(
				'kuantitas_keluar',
				'Kuantitas Keluar',
				'required|numeric|less_than_equal_to['.$post['stok'].']',
				[
					'required' => '{field} wajib diisi.',
					'numeric' => '{field} harus merupakan angka.',
					'less_than_equal_to' => '{field} tidak boleh lebih besar dari stok.'
				]
		);
		$this->form_validation->set_rules(
				'stok',
				'Stok Barang',
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

			$datedir  = explode('-', $post['tgl_pendataan']);

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

				$kode = strtoupper(random_char(5)).time();

				$data = array(
					'kode_barang' => $kode,
					'nama_barang' => ucwords($post['nama_barang']),
					'user_id' => $this->session->userdata('uid'),
					'keterangan' => $post['keterangan'],
					'tgl_pendataan' => $post['tgl_pendataan'],
					'kuantitas_masuk' => 0,
					'kuantitas_keluar' => $post['kuantitas_keluar'],
					'satuan' => strtoupper($post['satuan']),
					'dokumentasi' => $dokumentasi['file_name']
				);

				$status = ($this->inventarisasi_m->inputDataBarang($data) == true) ? 1 : 0;
				if($status === 1) $this->keuangan_m->inputDataKas($data);

				$msg 	= ($status === 1) ? 'Data berhasil diubah.' : 'Data gagal diubah.';
			}
			else
			{
				$msg = $this->secure_upload->show_errors();
			}

		} 
		else 
		{
			$msg = validation_errors();
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function edit($mode = NULL)
	{
		$status = 0;
		$msg 	= [];
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());

		// Get Image's filename without extension
		$filename = pathinfo($_FILES['dokumentasi']['name'], PATHINFO_FILENAME);

		// Remove another character except alphanumeric, space, dash, and underscore in filename
		$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

		// Remove space in filename
		$filename = str_replace(' ', '-', $filename);
		
		$datedir  = explode('-', $post['tgl_pendataan']);

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
			$msg[] 		 = $this->secure_upload->show_errors();
			$dokumentasi = $post['dokumentasi_old'];
		}

		switch ($mode) {
			case 'masuk':
				$this->form_validation->set_rules(
					'kuantitas_masuk',
					'Kuantitas Masuk',
					'required|numeric',
					[
						'required' => '{field} wajib diisi.',
						'numeric' => '{field} harus merupakan angka.'
					]
				);
				$this->form_validation->set_rules(
						'id_kategori',
						'Kategori',
						'integer',
						[
							'integer' => '{field} harus merupakan angka.'
						]
				);
				$this->form_validation->set_rules(
						'pengeluaran',
						'Pengeluaran',
						'numeric|less_than_equal_to['.$post['saldo'].']',
						[
							'required' => '{field} wajib diisi.',
							'numeric' => '{field} harus merupakan angka.',
							'less_than_equal_to' => '{field} tidak boleh lebih besar dari saldo.'
						]
				);
				$this->form_validation->set_rules(
						'saldo',
						'Saldo',
						'numeric',
						[
							'required' => '{field} wajib diisi.',
							'numeric' => '{field} harus merupakan angka.'
						]
				);
				$this->form_validation->set_rules(
						'kode_barang',
						'Kode Barang',
						'trim|regex_match[/[a-zA-Z0-9]+$/]|required|exact_length[15]',
						[
							'required' => '{field} wajib diisi.',
							'exact_length' => '{field} harus 10 huruf.',
							'regex_match' => '{field} harus alfanumerik.'
						]
				);

				$data = array(
					'nama_barang' => ucwords($post['nama_barang']),
					'keterangan' => $post['keterangan'],
					'tgl_pendataan' => $post['tgl_pendataan'],
					'kuantitas_keluar' => 0,
					'kuantitas_masuk' => $post['kuantitas_masuk'],
					'satuan' => strtoupper($post['satuan']),
					'dokumentasi' => $dokumentasi
				);

				$dataKas = array(
					'id_kategori' => $post['id_kategori'],
					'user_id' => $this->session->userdata('uid'),
					'keterangan' => $post['keterangan'],
					'date' => $post['tgl_pendataan'],
					'pengeluaran' => $post['pengeluaran'],
					'dokumentasi' => $dokumentasi
				);
				break;

			case 'keluar':
				$this->form_validation->set_rules(
					'kuantitas_keluar',
					'Kuantitas Keluar',
					'required|numeric|less_than_equal_to['.$post['stok'].']',
					[
						'required' => '{field} wajib diisi.',
						'numeric' => '{field} harus merupakan angka.',
						'less_than_equal_to' => '{field} tidak boleh lebih besar dari stok.'
					]
				);
				$this->form_validation->set_rules(
					'stok',
					'Stok Barang',
					'required|numeric',
					[
						'required' => '{field} wajib diisi.',
						'numeric' => '{field} harus merupakan angka.'
					]
				);

				$data = array(
					'nama_barang' => ucwords($post['nama_barang']),
					'keterangan' => $post['keterangan'],
					'tgl_pendataan' => $post['tgl_pendataan'],
					'kuantitas_masuk' => 0,
					'kuantitas_keluar' => $post['kuantitas_keluar'],
					'satuan' => strtoupper($post['satuan']),
					'dokumentasi' => $dokumentasi
				);

				break;

			default:
				show_404();
				break;
		}

		if ($this->form_validation->run() == TRUE) 
		{
			$status = ($this->inventarisasi_m->editDataBarang($data, $post['hash']) == true) ? 1 : 0;

			if($mode === 'masuk' && !empty($post['id_kategori']) && $status === 1)
			{
				if(empty($post['hidden_kategori']) && !empty($post['id_kategori'])) {
					$dataKas = array_merge($dataKas, ['kode_transaksi' => $post['kode_barang']]);
					$this->keuangan_m->inputDataKas($dataKas);
				}
				elseif(is_numeric($post['hidden_kategori']) && !empty($post['id_kategori']))
				{
					$this->keuangan_m->editKas($dataKas, $post['hash']);
				}
				elseif(is_numeric($post['hidden_kategori']) && empty($post['id_kategori']))
				{
					$this->keuangan_m->hapusKas($post['hash']);
				}
			}
			elseif($mode === 'masuk' && empty($post['id_kategori']) && $status === 1)
			{
				$this->keuangan_m->hapusKas($post['hash']);
			}
			else
			{
				// do nothing
			}

			$msg[] 	= ($status === 1) ? 'Data berhasil diubah.' : 'Data gagal diubah.';
		} 
		else 
		{
			$msg[]  = validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => implode(' ', $msg), 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$post = $this->input->post(null, TRUE);
		
		if(!verify($post['kode_barang']))
		{
			$status = 0;
			$msg = 'Anda belum memilih data yang akan dihapus.';
		}
		else
		{
			$status = ($this->inventarisasi_m->hapusBarang($post['kode_barang']) == true) ? 1 : 0;
			
			if($this->keuangan_m->hapusKas($post['kode_barang']) == true)
			{
				$msg_kas = 'Berhasil menghapus data barang.<br/>Berhasil menghapus kas pengeluaran.';
			}
			else
			{
				$msg_kas = 'Berhasil menghapus data barang.';
			}

			$msg = ($status === 1) ? $msg_kas : 'Gagal menghapus data.';
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function log()
	{
		$kode_barang = $this->input->post('kode_barang', TRUE);

		$data 	= (!verify($kode_barang)) ? [] : $this->inventarisasi_m->getLogs($kode_barang);

		$token 	= $this->security->get_csrf_hash();
		$result = array('log' => $data, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}