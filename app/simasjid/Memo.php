<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memo extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
	}

	public function index()
	{
		$status = 0;
		$post 	= $this->input->post(null, TRUE);

		$this->form_validation->set_rules(
			'user_id[]', 
			'Penerima', 
			'required|integer',
			array(
				'required' => 'Harap tentukan {field}.',
				'integer' => '{field} harus berupa integer.'
		));

		$this->form_validation->set_rules(
			'prioritas', 
			'Prioritas Memo', 
			'required|regex_match[/(biasa|khusus|mendesak|darurat)$/]',
			array(
				'required' => '{field} harus diisi.',
				'regex_match' => 'Pilihan {field} hanya biasa, khusus, mendesak, atau darurat.'
		));

		$this->form_validation->set_rules(
			'judul_memo', 
			'Judul Memo', 
			'trim|required|min_length[5]|max_length[100]|regex_match[/[a-zA-Z0-9 @\(-_+)&!?.,]+$/]',
			array(
				'required' => '{field} harus diisi.',
				'min_length' => 'Panjang {field} adalah 5-100 karakter',
				'max_length' => 'Panjang {field} adalah 5-100 karakter',
				'regex_match' => 'Karakter yang diizinkn untuk {field} adalah [a-zA-Z0-9 @\(-_+)&!?.,]'
		));

		$this->form_validation->set_rules(
			'isi_memo', 
			'Isi Memo', 
			'trim|required|min_length[5]|max_length[500]|regex_match[/[a-zA-Z0-9 @\(-_+)&!?.,]+$/]',
			array(
				'required' => '{field} harus diisi.',
				'min_length' => 'Panjang {field} adalah 5-500 karakter',
				'max_length' => 'Panjang {field} adalah 5-500 karakter',
				'regex_match' => 'Karakter yang diizinkn untuk {field} adalah [a-zA-Z0-9 @\(-_+)&!?.,]'
		));

		if ($this->form_validation->run() == TRUE) 
		{
			$status = ($this->memo_m->kirimMemo($post) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Berhasil mengirim memo.' : 'Gagal mengirim memo.';
		} 
		else 
		{
			$msg 	= validation_errors();
		}

		$token = $this->security->get_csrf_hash();
		$result = array('result' => $status, 'msg' => $msg, 'token' => $token);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function pemberitahuan_terbaru()
	{
		$notif = $this->memo_m->getMemo(6);
		$this->output->set_content_type('application/json')->set_output(json_encode($notif));
	}

	public function baca()
	{
		$post = $this->input->post(null, TRUE);
		
		$data = (!verify($post['memo_hash'])) ? [] : $this->memo_m->getMemoByHash($post['memo_hash']);
		
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function terbaca()
	{
		$memo = $this->input->post('id_memo', TRUE);
		$this->form_validation->set_rules('id_memo', 'ID Memo', 'required|integer');

		if ($this->form_validation->run() == TRUE) 
		{
			$status = ($this->memo_m->tandaiDibaca($memo) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? '' : 'Gagal membaca memo.';
		} 
		else 
		{
			$status = 0;
			$msg 	= validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function masuk()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min'
		);

		$this->_module 	= 'memo/memo_masuk_view';
		
		$this->css 		= 'w3-memo.min'; 
		$this->js 		= 'halaman/memo_masuk';

		$this->_data 	= array(
			'title' 	=> 'SIMASJID - Memo Masuk',
			'memo_masuk'=> $this->memo_m->getMemoMasukGroup()
		);

		$this->load_view();
	}

	public function keluar()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min'
		);

		$this->_module 	= 'memo/memo_keluar_view';
		
		$this->css 		= 'w3-memo.min'; 
		$this->js 		= 'halaman/memo_keluar';

		$this->_data 	= array(
			'title' 	  => 'SIMASJID - Memo Keluar',
			'memo_keluar' => $this->memo_m->getMemoKeluarGroup()
		);

		$this->load_view();
	}

	public function trash()
	{
		$this->css_plugin = array(
			'fontawesome/css/all.min',
			'mdi/css/materialdesignicons.min',
			'datatables/datatables.min'
		);

		$this->js_plugin = array(
			'datatables/datatables.min'
		);

		$this->_module 	= 'memo/memo_trash_view';
		
		$this->css 		= 'w3-memo.min'; 
		$this->js 		= 'halaman/memo_trash';

		$this->_data 	= array(
			'title' 	  => 'SIMASJID - Trash'
		);

		$this->load_view();
	}

	public function get_trash($flow = null)
	{
		$result = $this->memo_m->getTrash($flow);
		$this->output->set_content_type('application/json')->set_output(json_encode(['response' => $result]));
	}

	public function dari()
	{
		$post = $this->input->post(null, TRUE);
		
		$data = (!verify($post['dari'])) ? [] : $this->memo_m->getMemoBySender($post['dari']);
		
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, ['response' => $data]);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));		
	}

	public function kepada()
	{
		$post = $this->input->post(null, TRUE);
		
		$data = (!verify($post['kepada'])) ? [] : $this->memo_m->getMemoByReceiver($post['kepada']);
		
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, ['response' => $data]);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));		
	}

	public function hapus_memo_masuk()
	{
		$id_memo = $this->input->post('id_memo', TRUE);
		$this->form_validation->set_rules('id_memo', 'ID Memo', 'required|verify_hash');

		if ($this->form_validation->run() == TRUE) 
		{
			$status = ($this->memo_m->hapusMemoMasuk($id_memo) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Memo berhasil dihapus.' : 'Gagal menghapus memo.';
		} 
		else 
		{
			$status = 0;
			$msg 	= validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus_memo_keluar()
	{
		$id_memo = $this->input->post('id_memo', TRUE);
		$hapusSemua = $this->input->post('hapus_semua', TRUE);

		$this->form_validation->set_rules('id_memo', 'ID Memo', 'required|verify_hash');

		if ($this->form_validation->run() == TRUE) 
		{
			if($hapusSemua == '1')
			{
				$status = ($this->memo_m->hapusMemoKeluarUntukSemua($id_memo) == true) ? 1 : 0;
			}
			else
			{
				$status = ($this->memo_m->hapusMemoKeluar($id_memo) === true) ? 1 : 0;
			}

			$msg = ($status === 1) ? 'Memo berhasil dihapus.' : 'Gagal menghapus memo.';
		} 
		else 
		{
			$status = 0;
			$msg 	= validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus_semua_dari()
	{
		$pengirim = $this->input->post('dari', TRUE);
		$this->form_validation->set_rules('dari', 'Pengirim', 'required|verify_hash');

		if ($this->form_validation->run() == TRUE) 
		{
			$status = ($this->memo_m->hapusSemuaDari($pengirim) === true) ? 1 : 0;
			$msg 	= ($status === 1) ? 'Semua Memo berhasil dihapus' : 'Gagal menghapus memo.';
		} 
		else 
		{
			$status = 0;
			$msg 	= validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus_semua_kepada()
	{
		$penerima = $this->input->post('kepada', TRUE);
		$hapusSemua = $this->input->post('hapus_semua', TRUE);
		$this->form_validation->set_rules('kepada', 'Penerima', 'required|verify_hash');

		if ($this->form_validation->run() == TRUE) 
		{
			if($hapusSemua == '1')
			{
				$status = ($this->memo_m->hapusUntukSemua($penerima) == true) ? 1 : 0;
			}
			else
			{
				$status = ($this->memo_m->hapusSemuaKepada($penerima) === true) ? 1 : 0;
			}

			$msg = ($status === 1) ? 'Semua Memo berhasil dihapus' : 'Gagal menghapus memo.';
		} 
		else 
		{
			$status = 0;
			$msg 	= validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus_permanen($flow = null)
	{
		$status = 0;
		$hash 	= $this->input->post('id', TRUE);
		$this->form_validation->set_rules('id', 'Memo ID', 'required|verify_hash');

		if ($this->form_validation->run() == TRUE) 
		{
			switch ($flow) {
				case 'masuk':
					$status = ($this->memo_m->hapusMemoMasukPermanen($hash) === true) ? 1 : 0;
					$msg 	= ($status === 1) ? 'Memo berhasil dihapus.' : 'Memo gagal dihapus.';
					break;
				
				case 'keluar':
					$status = ($this->memo_m->hapusMemoKeluarPermanen($hash) === true) ? 1 : 0;
					$msg 	= ($status === 1) ? 'Memo berhasil dihapus.' : 'Memo gagal dihapus.';
					break;

				default:
					show_404();
					break;
			}
		}
		else
		{
			$msg = validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function kosongkan_trash($flow = null)
	{
		$status = 0;

		switch ($flow) {
			case 'masuk':
				$status = ($this->memo_m->hapusMemoMasukPermanen() === true) ? 1 : 0;
				$msg 	= ($status === 1) ? 'Memo berhasil dihapus.' : 'Memo gagal dihapus.';
				break;
			
			case 'keluar':
				$status = ($this->memo_m->hapusMemoKeluarPermanen() === true) ? 1 : 0;
				$msg 	= ($status === 1) ? 'Memo berhasil dihapus.' : 'Memo gagal dihapus.';
				break;

			default:
				show_404();
				break;
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function pulihkan($flow = null)
	{
		$status = 0;
		$hash 	= $this->input->post('id', TRUE);
		$this->form_validation->set_rules('id', 'Memo ID', 'required|verify_hash');

		if ($this->form_validation->run() == TRUE) 
		{
			switch ($flow) {
				case 'masuk':
					$status = ($this->memo_m->pulihkanMemoMasuk($hash) === true) ? 1 : 0;
					$msg 	= ($status === 1) ? 'Memo berhasil dipulihkan.' : 'Memo gagal dipulihkan.';
					break;
				
				case 'keluar':
					$status = ($this->memo_m->pulihkanMemoKeluar($hash) === true) ? 1 : 0;
					$msg 	= ($status === 1) ? 'Memo berhasil dipulihkan.' : 'Memo gagal dipulihkan.';
					break;

				default:
					show_404();
					break;
			}
		}
		else
		{
			$msg = validation_errors();
		}

		$result = array('result' => $status, 'msg' => $msg, 'token' => $this->security->get_csrf_hash());
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

/* End of file memo.php */
/* Location: ./application/controllers/memo.php */