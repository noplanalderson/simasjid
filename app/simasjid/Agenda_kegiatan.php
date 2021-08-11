<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_kegiatan extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();

		$this->load->model('kegiatan_m');
		$this->load->model('dokumentasi_m');
	}

	public function index()
	{
		$this->access_control->check_role();

		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min',
			'daterangepicker/daterangepicker',
			'datetimepicker/css/bootstrap-datetimepicker.min',
			'fileinput/css/fileinput.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min',
			'momentjs/moment.min',
			'momentjs/moment-timezone',
			'momentjs/moment-timezone-with-data',
			'momentjs/datetime-moment',
			'daterangepicker/daterangepicker',
			'datetimepicker/js/bootstrap-datetimepicker.min',
			'fileinput/js/plugins/piexif.min',
			'fileinput/js/plugins/sortable.min',
			'fileinput/js/fileinput.min',
			'fileinput/themes/fas/theme.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'agenda/agenda_kegiatan';
		
		$this->js 		= 'halaman/agenda_kegiatan';
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Agenda Kegiatan',
			'jenis' 	=> $this->kegiatan_m->getJenisAgenda(),
			'agenda'	=> $this->kegiatan_m->getAgenda(),
			'btn_add' 	=> $this->app_m->getContentMenu('tambah-agenda'),
			'btn_edit' 	=> $this->app_m->getContentMenu('edit-agenda'),
			'btn_del' 	=> $this->app_m->getContentMenu('hapus-agenda'),
			'btn_upload'=> $this->app_m->getContentMenu('unggah-foto')
		);

		$this->load_view();
	}

	public function kalender()
	{
		$this->access_control->check_role();

		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'fullcalendar/lib/main.min'
		);

		$this->js_plugin = array(
			'momentjs/moment.min',
			'momentjs/moment-timezone',
			'momentjs/moment-timezone-with-data',
			'fullcalendar/lib/main.min'
		);

		$this->_partial = array(
			'head',
			'sidebar',
			'navbar',
			'body',
			'footer',
			'script'
		);

		$this->_module 	= 'agenda/kalender_view';
		
		$this->js 		= 'halaman/kalender';
		
		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Kalender Kegiatan'
		);

		$this->load_view();
	}

	public function data_kalender()
	{
		$this->output->set_content_type('application/json')->set_output(json_encode(
			['response' => $this->kegiatan_m->getAgenda()]
		));
	}

	public function get()
	{
		$this->access_control->check_role();

		$post 	= $this->input->post(null, TRUE);
		
		$data 	= (!verify($post['id_kegiatan'])) ? [] : $this->kegiatan_m->getAgendaByHash($post['id_kegiatan']);
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	function valid_time($str)
	{
		$valid = preg_match('/((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AaPp][Mm]))/', $str);

		if($valid)
		{
            $this->form_validation->set_message('valid_time', 'Format {field} harus 00:00 AM/PM');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
	}

	function _rules()
	{
		$rules = array(
			array(
				'field' => 'id_kegiatan',
				'label' => 'ID Kegiatan',
				'rules' => 'trim|verify_hash',
				'errors'=> [
					'verify_hash' => '{field} tidak valid.'
				]
			),
			array(
				'field' => 'tanggal',
				'label' => 'Tanggal',
				'rules' => 'required|regex_date',
				'errors'=> [
					'required' => '{field} harus diisi.',
					'regex_date' => '{field} harus merupakan tanggal yang valid.'
				]
			),
			array(
				'field' => 'jam_mulai',
				'label' => 'Jam Mulai',
				'rules' => 'required|callback_valid_time',
				'errors'=> [
					'required' => '{field} harus diisi.'
				]
			),
			array(
				'field' => 'jam_selesai',
				'label' => 'Jam Selesai',
				'rules' => 'callback_valid_time'
			),
			array(
				'field' => 'judul_kegiatan',
				'label' => 'Judul Kegiatan',
				'rules' => 'trim|required|min_length[5]|max_length[255]|regex_match[/[a-zA-Z0-9 (\-_,)&.\']+$/]',
				'errors'=> array(
					'required' => '{field} harus diisi.',
					'min_length' => 'Panjang minimal {field} {param} karakter',
					'max_length' => 'Panjang maksiml {field} {param} karakter',
					'regex_match'=> '{field} hanya  boleh mengandung alfanumerik dan [(\-_,)&.\']'
				)
			),
			array(
				'field' => 'narasumber',
				'label' => 'Narasumber',
				'rules' => 'trim|required|min_length[5]|max_length[255]|regex_match[/[a-zA-Z0-9 ,.\']+$/]',
				'errors'=> array(
					'required' => '{field} harus diisi.',
					'min_length' => 'Panjang minimal {field} {param} karakter',
					'max_length' => 'Panjang maksiml {field} {param} karakter',
					'regex_match'=> '{field} hanya  boleh mengandung alfanumerik dan [,.\']'
				)
			),
			array(
				'field' => 'keterangan',
				'label' => 'Keterangan',
				'rules' => 'trim|min_length[5]|max_length[255]|regex_match[/[a-zA-Z0-9 ()\-_%\/&.,]+$/]',
				'errors'=> [
					'min_length' => '{field} harus terdiri dari 5-255 karakter.',
					'max_length' => '{field} harus terdiri dari 5-255 karakter.',
					'regex_match' => '{field} hanya boleh berisi karakter [a-zA-Z0-9 ()-_%/&.,]'
				]
			)
		);

		return $rules;
	}

	public function tambah()
	{
		$this->access_control->check_role();

		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			$data = array(
				'id_jenis' => $post['id_jenis'],
				'user_id' => $this->session->userdata('uid'),
				'tanggal' => $post['tanggal'],
				'jam_mulai' => $post['jam_mulai'],
				'jam_selesai' => empty($post['jam_selesai']) ? null : $post['jam_selesai'],
				'judul_kegiatan' => ucwords($post['judul_kegiatan']),
				'narasumber' => ucwords($post['narasumber']),
				'keterangan' => empty($post['keterangan']) ? null : $post['keterangan']
			);

			$status = ($this->kegiatan_m->tambahAgenda($data) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Agenda berhasil ditambahkan.' : 'Agenda gagal ditambahkan.';
		} 
		else 
		{
			$msg  	= validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function edit()
	{
		$this->access_control->check_role();

		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules($this->_rules());
		
		if ($this->form_validation->run() == TRUE) 
		{
			$data = array(
				'id_jenis' => $post['id_jenis'],
				'tanggal' => $post['tanggal'],
				'jam_mulai' => $post['jam_mulai'],
				'jam_selesai' => empty($post['jam_selesai']) ? null : $post['jam_selesai'],
				'judul_kegiatan' => ucwords($post['judul_kegiatan']),
				'narasumber' => ucwords($post['narasumber']),
				'keterangan' => empty($post['keterangan']) ? null : $post['keterangan']
			);

			$status = ($this->kegiatan_m->editAgenda($data, $post['id_kegiatan']) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Agenda berhasil diubah.' : 'Agenda gagal diubah.';
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
		$this->access_control->check_role();

		$post = $this->input->post(null, TRUE);
		
		if(!verify($post['id_kegiatan']))
		{
			$status = 0;
			$msg = 'Anda belum memilih agenda yang akan dihapus.';
		}
		else
		{
			$status = ($this->kegiatan_m->hapusAgenda($post['id_kegiatan']) == true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Berhasil menghapus agenda.' : 'Gagal menghapus agenda.';
		}

		$token 	= $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}