<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memo_m extends CI_Model {

	public function kirimMemo($data)
	{
		$jumlahPenerima = count($data['user_id']);

		for ($i = 0; $i < $jumlahPenerima; $i++) {
			$this->db->insert('tb_memo', [
				'dari' => $this->session->userdata('uid'),
				'prioritas' => $data['prioritas'],
				'kepada' => $data['user_id'][$i],
				'judul_memo' => $data['judul_memo'],
				'isi_memo' => $data['isi_memo']
			]);
		}

		return true;
	}

	public function getMemo($limit = null)
	{
		$notif = [];

		$this->db->select('a.id, a.prioritas, a.judul_memo, a.dari, a.isi_memo, a.datetime, a.dibaca, b.real_name, b.user_picture');
		$this->db->join('tb_user b', 'a.dari = b.user_id', 'left');
		$this->db->where('a.kepada', $this->session->userdata('uid'));
		$this->db->order_by('a.datetime', 'desc');
		if(!is_null($limit)) $this->db->limit($limit);
		$memo = $this->db->get('tb_memo a')->result();

		foreach ($memo as $m) {
			$notif[] = [
				'id' => encrypt($m->id),
				'prioritas' => $m->prioritas,
				'judul' => $m->judul_memo, 
				'dari' => encrypt($m->dari), 
				'isi' => teaser($m->isi_memo, 50), 
				'nama_pengirim' => $m->real_name,
				'foto' => $m->user_picture,
				'datetime' => indonesian_date($m->datetime, true, true),
				'dibaca' => $m->dibaca
			];
		}

		return $notif;
	}

	public function getMemoByHash($hash)
	{
		$this->db->select('a.id, a.prioritas, a.judul_memo, a.isi_memo, a.datetime, b.real_name');
		$this->db->join('tb_user b', 'a.dari = b.user_id', 'left');
		$this->db->where('md5(a.id)', verify($hash));
		$memo = $this->db->get('tb_memo a')->row_array();

		return array_merge($memo, ['tanggal' => indonesian_date($memo['datetime'], true, true)]);
	}

	public function tandaiDibaca($id_memo)
	{
		$this->db->where('id', $id_memo);
		$this->db->update('tb_memo', ['dibaca' => 1]);
		return ($this->db->affected_rows() === 1) ? true : false;
	}

	public function countMemoOut()
	{
		$this->db->where('dari', $this->session->userdata('uid'));
		return $this->db->get('tb_memo')->num_rows();
	}

	public function countMemoUnread()
	{
		$this->db->where('dari !=', $this->session->userdata('uid'));
		$this->db->where('dibaca', 0);
		return $this->db->get('tb_memo')->num_rows();
	}

	public function countMemoIn()
	{
		$this->db->where('dari !=', $this->session->userdata('uid'));
		return $this->db->get('tb_memo')->num_rows();
	}

	public function countTrash()
	{
		$this->db->where('kepada', $this->session->userdata('uid'));
		$this->db->where('receiver_deletion', 1);
		$this->db->or_where('dari', $this->session->userdata('uid'));
		$this->db->where('sender_deletion', 1);
		return $this->db->get('tb_memo')->num_rows();
	}

	public function getMemoMasuk()
	{
		$this->db->select('a.id, a.datetime, a.dari, a.judul_memo, a.isi_memo, b.real_name, b.user_picture');
		$this->db->join('tb_user b', 'a.dari = b.user_id', 'left');
		$this->db->where('a.kepada', $this->session->userdata('uid'));
		$this->db->order_by('a.datetime', 'desc');
		return $this->db->get('tb_memo a')->result_array();
	}

	public function getMemoMasukGroup()
	{
		$this->db->select('a.id, a.dari, b.real_name, b.user_picture');
		$this->db->join('tb_user b', 'a.dari = b.user_id', 'left');
		$this->db->where('a.kepada', $this->session->userdata('uid'));
		$this->db->where('a.receiver_deletion', 0);
		$this->db->group_by('a.dari');
		$this->db->order_by('a.datetime', 'desc');
		return $this->db->get('tb_memo a')->result();
	}

	public function getMemoKeluarGroup()
	{
		$this->db->select('a.id, a.kepada, b.real_name, b.user_picture');
		$this->db->join('tb_user b', 'a.kepada = b.user_id', 'left');
		$this->db->where('a.dari', $this->session->userdata('uid'));
		$this->db->where('a.sender_deletion', 0);
		$this->db->group_by('a.kepada');
		$this->db->order_by('a.datetime', 'desc');
		return $this->db->get('tb_memo a')->result();
	}

	public function getTrash($flow)
	{
		
		switch ($flow) {
			case 'masuk':
				
				$this->db->select('a.id, a.judul_memo, a.datetime, b.real_name');
				$this->db->join('tb_user b', 'b.user_id = a.dari', 'left');
				$this->db->where('a.kepada', $this->session->userdata('uid'));
				$this->db->where('a.receiver_deletion', 1);
				break;
			
			default:
				$this->db->select('a.id, a.judul_memo, a.datetime, b.real_name');
				$this->db->join('tb_user b', 'b.user_id = a.kepada', 'left');
				$this->db->where('a.dari', $this->session->userdata('uid'));
				$this->db->where('a.sender_deletion', 1);
				break;
		}

		$this->db->order_by('a.datetime', 'desc');
		$memos = $this->db->get('tb_memo a')->result_array();

		$memo_list = [];

		foreach ($memos as $memo) {
			$memo_list[] = [
				'id' => $memo['id'],
				'judul_memo' => $memo['judul_memo'],
				'real_name' => $memo['real_name'],
				'datetime' => indonesian_date($memo['datetime'], true , true),
				'hash' => encrypt($memo['id'])
			];
		}
		
		return $memo_list;
	}

	public function getMemoBySender($dari)
	{
		$this->db->select('id, prioritas, judul_memo, datetime, dibaca');
		$this->db->where('md5(dari)', verify($dari));
		$this->db->where('kepada', $this->session->userdata('uid'));
		$this->db->where('receiver_deletion', 0);
		$this->db->order_by('dibaca', 'asc');
		$this->db->order_by('datetime', 'desc');
		$memos = $this->db->get('tb_memo')->result_array();

		$memo_list = [];

		foreach ($memos as $memo) {
			$memo_list[] = [
				'id' => $memo['id'],
				'prioritas' => $memo['prioritas'],
				'judul_memo' => $memo['judul_memo'],
				'datetime' => indonesian_date($memo['datetime'], true , true),
				'hash' => encrypt($memo['id']),
				'dibaca' => $memo['dibaca']
			];
		}

		return $memo_list;
	}

	public function getMemoByReceiver($kepada)
	{
		$this->db->select('id, prioritas, judul_memo, datetime, dibaca');
		$this->db->where('md5(kepada)', verify($kepada));
		$this->db->where('dari', $this->session->userdata('uid'));
		$this->db->where('sender_deletion', 0);
		$this->db->order_by('dibaca', 'asc');
		$this->db->order_by('datetime', 'desc');
		$memos = $this->db->get('tb_memo')->result_array();

		$memo_list = [];

		foreach ($memos as $memo) {
			$memo_list[] = [
				'id' => $memo['id'],
				'prioritas' => $memo['prioritas'],
				'judul_memo' => $memo['judul_memo'],
				'datetime' => indonesian_date($memo['datetime'], true , true),
				'hash' => encrypt($memo['id']),
				'dibaca' => $memo['dibaca']
			];
		}

		return $memo_list;
	}

	public function hapusMemoMasuk($id)
	{
		$this->db->where('md5(id)', verify($id));
		$this->db->update('tb_memo', ['receiver_deletion' => 1]);
		return ($this->db->affected_rows() === 1) ? true : false;
	}

	public function hapusMemoKeluar($id)
	{
		$this->db->where('md5(id)', verify($id));
		$this->db->update('tb_memo', ['sender_deletion' => 1]);
		return ($this->db->affected_rows() === 1) ? true : false;
	}

	public function hapusMemoKeluarUntukSemua($id)
	{
		$this->db->where('md5(id)', verify($id));
		$this->db->delete('tb_memo');
		return ($this->db->affected_rows() === 1) ? true : false;
	}

	public function hapusSemuaDari($dari)
	{
		$this->db->where('md5(dari)', verify($dari));
		$this->db->where('kepada', $this->session->userdata('uid'));
		$this->db->update('tb_memo',['receiver_deletion' => 1]);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function hapusSemuaKepada($kepada)
	{
		$this->db->where('md5(kepada)', verify($kepada));
		$this->db->where('dari', $this->session->userdata('uid'));
		$this->db->update('tb_memo',['sender_deletion' => 1]);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function hapusUntukSemua($kepada)
	{
		$this->db->where('md5(kepada)', verify($kepada));
		$this->db->where('dari', $this->session->userdata('uid'));
		$this->db->delete('tb_memo');
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function hapusMemoMasukPermanen($hash = null)
	{
		if(!is_null($hash)) {
			$this->db->where('md5(id)', verify($hash));
		}
		
		$this->db->where('receiver_deletion', 1);
		$this->db->where('kepada', $this->session->userdata('uid'));
		$this->db->update('tb_memo', ['receiver_deletion' => 2]);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function hapusMemoKeluarPermanen($hash = null)
	{
		if(!is_null($hash)) {
			$this->db->where('md5(id)', verify($hash));
		}
		
		$this->db->where('sender_deletion', 1);
		$this->db->where('dari', $this->session->userdata('uid'));
		$this->db->update('tb_memo', ['sender_deletion' => 2]);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function pulihkanMemoMasuk($hash)
	{
		$this->db->where('md5(id)', verify($hash));
		$this->db->where('kepada', $this->session->userdata('uid'));
		$this->db->update('tb_memo', ['receiver_deletion' => 0]);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function pulihkanMemoKeluar($hash)
	{
		$this->db->where('md5(id)', verify($hash));
		$this->db->where('dari', $this->session->userdata('uid'));
		$this->db->update('tb_memo', ['sender_deletion' => 0]);
		return ($this->db->affected_rows() > 0) ? true : false;
	}
}

/* End of file memo_m.php */
/* Location: ./application/models/memo_m.php */