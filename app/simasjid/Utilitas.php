<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilitas extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();

		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('utilitas_m');
	}

	public function index()
	{
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

		$this->_module 	= 'utilitas/utilitas_view';

		$this->js 		= 'halaman/utilitas';

		$this->_data	= array(
			'title'		=> 'SIMASJID - Utilitas',
			'kategori' 	=> $this->utilitas_m->getKategori(),
			'jabatan'	=> $this->utilitas_m->getJabatan(),
			'user_type' => $this->utilitas_m->getUserType(),
			'kegiatan'	=> $this->utilitas_m->getJenisKegiatan(),
			'btn_edit'	=> $this->app_m->getContentMenu('edit-utilitas'),
			'btn_delete'=> $this->app_m->getContentMenu('hapus-utilitas'),
			'btn_add'	=> $this->app_m->getContentMenu('tambah-utilitas'),
		);

		$this->load_view();
	}

	public function get_utilitas($item = NULL)
	{
		$hash 	= $this->input->post('id', TRUE);
		$data 	= [];

		if( ! verify($hash)) :
			return false;
		else :

			switch ($item) {
				case 'kategori':
					$data 	= $this->utilitas_m->getKategoriByHash($hash);
					break;
				
				case 'jabatan':
					$data 	= $this->utilitas_m->getJabatanByHash($hash);
					break;

				case 'jenis-kegiatan':
					$data 	= $this->utilitas_m->getJenisKegiatanByHash($hash);
					break;

				default:
					show_404();
					break;
			}

			$token 	= array('token' => $this->security->get_csrf_hash());
			$result	= array_merge($token, $data);

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		endif;
	}

	function _kategoriRule()
	{
		$rules = array(
			array(
				'field' => 'id_kategori',
				'label' => 'ID Kategori',
				'rules' => 'trim|verify_hash',
				'errors'=> [
					'verify_hash' => '{field} tidak valid.'
				]
			),
			array(
				'field' => 'kategori',
				'label' => 'Kategori',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z0-9 -_\']+$/]|min_length[3]|max_length[100]|is_unique[tb_kategori_kas.kategori]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumeric dan [-_\'].',
					'min_length' => 'Panjang {field} minimal {param} karakater.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.',
					'is_unique' => '{field} sudah ada.'
				]
			)
		);

		return $rules;
	}

	function _jabatanRule()
	{
		$rules = array(
			array(
				'field' => 'id_jabatan',
				'label' => 'ID Jabatan',
				'rules' => 'trim|verify_hash',
				'errors'=> [
					'verify_hash' => '{field} tidak valid.'
				]
			),
			array(
				'field' => 'nama_jabatan',
				'label' => 'Nama Jabatan',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z0-9 -_]+$/]|min_length[3]|max_length[100]|is_unique[tb_jabatan.nama_jabatan]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumeric dan [-_].',
					'min_length' => 'Panjang {field} minimal {param} karakater.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.',
					'is_unique' => '{field} sudah ada.'
				]
			),
			array(
				'field' => 'type_id',
				'label' => 'Tipe User',
				'rules'	=> 'required|integer',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'integer' => '{field} harus angka.',
				]
			)
		);

		return $rules;
	}

	function _jenisKegiatanRule()
	{
		$rules = array(
			array(
				'field' => 'id_jenis',
				'label' => 'ID Jenis Kegiatan',
				'rules' => 'trim|verify_hash',
				'errors'=> [
					'verify_hash' => '{field} tidak valid.'
				]
			),
			array(
				'field' => 'jenis_kegiatan',
				'label' => 'Jenis Kegiatan',
				'rules'	=> 'trim|required|regex_match[/[a-zA-Z0-9 -_\']+$/]|min_length[3]|max_length[100]|is_unique[tb_jenis_kegiatan.jenis_kegiatan]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumeric dan [-_\'].',
					'min_length' => 'Panjang {field} minimal {param} karakater.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.',
					'is_unique' => '{field} sudah ada.'
				]
			)
		);

		return $rules;
	}
	public function tambah($item = NULL)
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);
		
		switch ($item) {
			case 'kategori':
				$this->form_validation->set_rules($this->_kategoriRule());

				if ($this->form_validation->run() == TRUE) {
					$status  = ($this->utilitas_m->tambahKategori($post) == true) ? 1 : 0;
					$msg 	 = ($status === 1) ? 'Kategori berhasil ditambahkan.' : 'Gagal menambahkan kategori.';
				}
				else
				{
					$msg 	 = validation_errors();
				}
				break;
			
			case 'jabatan':
				$this->form_validation->set_rules($this->_jabatanRule());

				if ($this->form_validation->run() == TRUE) {
					$status  = ($this->utilitas_m->tambahJabatan($post) == true) ? 1 : 0;
					$msg 	 = ($status === 1) ? 'Jabatan berhasil ditambahkan.' : 'Gagal menambahkan jabatan.';
				}
				else
				{
					$msg 	 = validation_errors();
				}
				break;

			case 'jenis-kegiatan':
				$this->form_validation->set_rules($this->_jenisKegiatanRule());

				if ($this->form_validation->run() == TRUE) {
					$status  = ($this->utilitas_m->tambahJenisKegiatan($post) == true) ? 1 : 0;
					$msg 	 = ($status === 1) ? 'Jenis kegiatan berhasil ditambahkan.' : 'Gagal menambahkan jenis kegiatan.';
				}
				else
				{
					$msg 	 = validation_errors();
				}
				break;

			default:
				show_404();
				break;
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function edit($item = NULL)
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);
		
		switch ($item) {
			case 'kategori':
				$this->form_validation->set_rules('id_kategori', 'ID Kategori', 'trim|required|verify_hash');
				$this->form_validation->set_rules('kategori', 'Ketegori', 'trim|required|regex_match[/[a-zA-Z0-9 -_\']+$/]|min_length[3]|max_length[100]', [
					'required' 		=> '{field} harus diisi.',
					'regex_match' 	=> '{field} hanya boleh mengandung karakter alfanumeric dan [-_\'].',
					'min_length' 	=> 'Panjang {field} minimal {param} karakater.',
					'max_length' 	=> 'Panjang {field} maksimal {param} karakater.'
				]);

				if ($this->form_validation->run() == TRUE) {

					if($this->utilitas_m->cekKategori($post) == 0)
					{
						$status  = ($this->utilitas_m->editKategori($post) == true) ? 1 : 0;
						$msg 	 = ($status === 1) ? 'Kategori berhasil diubah.' : 'Gagal mengubah kategori.';
					}
					else
					{
						$msg 	 = 'Kategori sudah ada.';
					}
				}
				else
				{
					$msg 	 = validation_errors();
				}
				break;
			
			case 'jabatan':
				$this->form_validation->set_rules('id_jabatan', 'ID Jabatan', 'trim|required|verify_hash');
				$this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'trim|required|regex_match[/[a-zA-Z0-9 -_]+$/]|min_length[3]|max_length[100]', [
					'required' 		=> '{field} harus diisi.',
					'regex_match' 	=> '{field} hanya boleh mengandung karakter alfanumeric dan [-_\'].',
					'min_length' 	=> 'Panjang {field} minimal {param} karakater.',
					'max_length' 	=> 'Panjang {field} maksimal {param} karakater.'
				]);
				$this->form_validation->set_rules('type_id', 'Tipe User', 'required|integer');

				if ($this->form_validation->run() == TRUE) {
					
					if($this->utilitas_m->cekJabatan($post) == 0)
					{
						$status  = ($this->utilitas_m->editJabatan($post) == true) ? 1 : 0;
						$msg 	 = ($status === 1) ? 'Jabatan berhasil diubah.' : 'Gagal mengubah jabatan.';
					}
					else
					{
						$msg 	 = 'Jabatan sudah ada.';
					}
				}
				else
				{
					$msg 	 = validation_errors();
				}
				break;

			case 'jenis-kegiatan':
				$this->form_validation->set_rules('id_jenis', 'ID Jenis Kegiatan', 'required|verify_hash');
				$this->form_validation->set_rules('jenis_kegiatan', 'Jenis Kegiatan', 'trim|required|regex_match[/[a-zA-Z0-9 -_\']+$/]|min_length[3]|max_length[100]', [
					'required' 		=> '{field} harus diisi.',
					'regex_match' 	=> '{field} hanya boleh mengandung karakter alfanumeric dan [-_\'].',
					'min_length' 	=> 'Panjang {field} minimal {param} karakater.',
					'max_length' 	=> 'Panjang {field} maksimal {param} karakater.'
				]);

				if ($this->form_validation->run() == TRUE) {

					if($this->utilitas_m->cekJenisKegiatan($post) == 0)
					{
						$status  = ($this->utilitas_m->editJenisKegiatan($post) == true) ? 1 : 0;
						$msg 	 = ($status === 1) ? 'Jenis Kegiaatan berhasil diubah.' : 'Gagal mengubah jenis kegiatan.';
					}
					else
					{
						$msg 	 = 'Jenis Kegiaatan sudah ada.';
					}
				}
				else
				{
					$msg 	 = validation_errors();
				}
				break;

			default:
				show_404();
				break;
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus($item = NULL)
	{
		$hash 	= $this->input->post('id', TRUE);
		$status = 0;

		if( ! verify($hash)) :
			$msg = 'Invalid ID.';
		else :
		
			switch ($item) {
				case 'kategori':

					$status  = ($this->utilitas_m->hapusKategori($hash) == true) ? 1 : 0;
					$msg 	 = ($status === 1) ? 'Kategori berhasil dihapus.' : 'Gagal menghapus kategori.';
				
				case 'jabatan':

					$status  = ($this->utilitas_m->hapusJabatan($hash) == true) ? 1 : 0;
					$msg 	 = ($status === 1) ? 'Jabatan berhasil dihapus.' : 'Gagal menghapus jabatan.';

					break;

				case 'jenis-kegiatan':

					$status  = ($this->utilitas_m->hapusJenisKegiatan($hash) == true) ? 1 : 0;
					$msg 	 = ($status === 1) ? 'Jenis kegiatan berhasil dihapus.' : 'Gagal menghapus jenis kegiatan.';

					break;

				default:
					show_404();
					break;
			}
		endif;

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}