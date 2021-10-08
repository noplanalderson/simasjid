<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zakat_mal extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('zakat_mal_m');
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

		$this->_module 	= 'zakat_mal/zakat_mal_view';
		
		$this->js 		= 'halaman/zakat_mal';
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Zakat Mal Masuk',
			'card_title'=> 'Data Muzakki / Zakat Masuk',
			'btn_class' => 'tambah-muzakki',
			'muzakki' 	=> $this->zakat_mal_m->getZakatMal('masuk'),
			'btn_add' 	=> $this->app_m->getContentMenu('tambah-zakat-mal'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-zakat-mal'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-zakat-mal'),
			'btn_log'	=> $this->app_m->getContentMenu('log-zakat-mal'),
			'btn_kwitansi'	=> $this->app_m->getContentMenu('kwitansi-zakat-mal')
		);

		$this->load_view();
	}

	public function mustahik()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/css/timeline.min',
			'easyautocomplete/easy-autocomplete.min',
			'easyautocomplete/easy-autocomplete.themes.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min',
			'momentjs/moment.min',
			'momentjs/moment-timezone',
			'momentjs/moment-timezone-with-data',
			'momentjs/datetime-moment',
			'daterangepicker/daterangepicker',
			'timeline-master/dist/js/timeline.min',
			'easyautocomplete/jquery.easy-autocomplete.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'zakat_mal/zakat_mal_view';
		
		$this->js 		= ['halaman/zakat_mal', 'halaman/data_mustahik'];
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Zakat Mal Keluar',
			'card_title'=> 'Data Mustahik / Zakat Keluar',
			'btn_class' => 'tambah-mustahik',
			'muzakki' 	=> $this->zakat_mal_m->getZakatMal('keluar'),
			'btn_add' 	=> $this->app_m->getContentMenu('tambah-zakat-mal'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-zakat-mal'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-zakat-mal'),
			'btn_log'	=> $this->app_m->getContentMenu('log-zakat-mal'),
			'btn_kwitansi'	=> $this->app_m->getContentMenu('kwitansi-zakat-mal')
		);

		$this->load_view();
	}

	public function rekapitulasi()
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

		$this->_module 	= 'zakat_mal/rekap_zakat_view';
		
		$this->js 		= 'halaman/rekap_zakat';
		
		$this->_data 	= array(
			'title' 	 => 'SIMASJID - Rekapitulasi Zakat Mal',
			'rekap_zakat'=> $this->zakat_mal_m->rekapitulasiZakat()
		);

		$this->load_view();
	}

	private function  _rules()
	{
		$rules = array(
			array(
				'field' => 'date',
				'label' => 'Tanggal',
				'rules' => 'required|regex_date',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_date' => 'Format {field} tidak valid.'
				]
			),
			array(
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'required|regex_match[/(masuk|keluar)$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_date' => 'Format {field} tidak valid.'
				]
			),
			array(
				'field' => 'atas_nama',
				'label' => 'Atas Nama',
				'rules' => 'trim|required|regex_match[/[a-zA-Z0-9 \'.,]+$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter alfanumerik dan [\'.,].'
				]
			),
			array(
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules'	=> 'trim|regex_match[/[a-zA-Z0-9 @&#\/\-_.,]+$/]|min_length[3]|max_length[500]',
				'errors'=> [
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @&#\/\-_.,].',
					'min_length' => 'Panjang {field} minimal {param} karakater.',
					'max_length' => 'Panjang {field} maksimal {param} karakater.'
				]
			),
			array(
				'field' => 'no_telepon',
				'label' => 'No. Telepon',
				'rules' => 'trim|phone_regex',
				'errors'=> [
					'phone_regex' => 'Format {field} yang valid (+62xxx / 021xxx / xxx-xxx) maksimal 16 karakter.'
				]
			),
			array(
				'field' => 'bentuk_zakat',
				'label' => 'Bentuk Zakat',
				'rules' => 'required|regex_match[/[a-zA-Z0-9 \']+$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 \'].'
				]
			),
			array(
				'field' => 'satuan_zakat',
				'label' => 'Satuan Zakat',
				'rules' => 'required|regex_match[/(RUPIAH|KILOGRAM|GRAM|LITER|EKOR)$/]',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_match' => '{field} tidak valid.'
				]
			),
			array(
				'field' => 'jumlah_jiwa',
				'label' => 'Jumlah Jiwa',
				'rules' => 'integer|max_length[11]',
				'errors'=> [
					'integer' => '{field} harus angka.'
				]
			),
			array(
				'field' => 'jumlah_zakat',
				'label' => 'Jumlah Zakat',
				'rules' => 'required|numeric',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'numeric' => '{field} harus angka.'
				]
			)
		);

		return $rules;
	}

	private function _createQRCode($kode_transaksi)
	{
		if (!is_dir(FCPATH . '_/uploads/qrcode/')) mkdir(FCPATH . '_/uploads/qrcode/', 0755, true);
		
		$this->load->library('ciqrcode');
		
		$params['data'] 	= base64url_encode(encrypt($kode_transaksi));
		$params['level'] 	= 'L';
		$params['size'] 	= 4;
		$params['savename'] = FCPATH . '_/uploads/qrcode/'.base64url_encode(encrypt($kode_transaksi)).'.png';
		$this->ciqrcode->generate($params);
	}

	public function tambah()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			$kode_transaksi = strtoupper(random_char(5)).time();

			$data = array(
				'kode_transaksi' => $kode_transaksi,
				'status' => $post['status'],
				'user_id' => $this->session->userdata('uid'),
				'atas_nama' => ucwords($post['atas_nama']),
				'date' => $post['date'],
				'alamat' => $post['alamat'],
				'no_telepon' => $post['no_telepon'],
				'bentuk_zakat' => $post['bentuk_zakat'],
				'satuan_zakat' => $post['satuan_zakat'],
				'jumlah_jiwa' => $post['jumlah_jiwa'],
				'jumlah_zakat' => $post['jumlah_zakat']
			);

			$status = ($this->zakat_mal_m->tambahZakatMal($data) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Data berhasil ditambahkan.' : 'Data gagal ditambahkan.';

			if($status === 1) $this->_createQRCode($kode_transaksi);
		} 
		else 
		{
			$msg  	= validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function get_zakat()
	{
		$post = $this->input->post(null, TRUE);
		
		$data = (!verify($post['kode_transaksi'])) ? [] : $this->zakat_mal_m->getZakatByKodeTransaksi($post['kode_transaksi']);
		
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function edit()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			$data = array(
				'status' => $post['status'],
				'user_id' => $this->session->userdata('uid'),
				'atas_nama' => ucwords($post['atas_nama']),
				'date' => $post['date'],
				'alamat' => $post['alamat'],
				'no_telepon' => $post['no_telepon'],
				'bentuk_zakat' => $post['bentuk_zakat'],
				'satuan_zakat' => $post['satuan_zakat'],
				'jumlah_jiwa' => $post['jumlah_jiwa'],
				'jumlah_zakat' => $post['jumlah_zakat']
			);

			$status = ($this->zakat_mal_m->editZakatMal($data, $post['kode_transaksi']) == true) ? 1 : 0;
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
			$status = ($this->zakat_mal_m->hapusZakatMal($post['kode_transaksi']) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Berhasil menghapus data.' : 'Gagal menghapus data.';
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function log()
	{
		$kode_transaksi = $this->input->post('kode_transaksi', TRUE);

		$data 	= (!verify($kode_transaksi)) ? [] : $this->zakat_mal_m->getLogs($kode_transaksi);

		$token 	= $this->security->get_csrf_hash();
		$result = array('log' => $data, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function kwitansi($hash = NULL)
	{
		$hash 		= verify(base64url_decode($hash));
		$transaksi 	= $this->zakat_mal_m->getDetailTransaksi($hash);

		if(empty($transaksi)) show_404();

		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'zakat_mal/kw_zakat_mal_view';
		
		$this->js 		= 'halaman/kw_zakat_fitrah';
		
		$this->_data 	= array(
			'title' 	=> 'Zakat  Mal - '.$transaksi->kode_transaksi.' - '.$transaksi->atas_nama,
			'status'	=> ($transaksi->status == 'masuk') ? 'Pembayaran' : 'Penerimaan',
			'transaksi' => $transaksi
		);

		$this->load_view();
	}
}