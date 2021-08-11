<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_mustahik_m extends CI_Model {

	public function getDataMustahik()
	{
		$this->db->select('a.*, b.real_name');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->order_by('a.nama', 'asc');
		return $this->db->get('tb_mustahik a')->result();
	}

	public function getDataByHash($hash)
	{
		$this->db->where('md5(id_mustahik)', verify($hash));
		return $this->db->get('tb_mustahik')->row_array();
	}

	public function tambahData($data)
	{
		return $this->db->insert('tb_mustahik', $data) ? true : false;
	}

	public function editData($data, $id)
	{
		$this->db->where('md5(id_mustahik)', verify($id));
		return $this->db->update('tb_mustahik', $data) ? true : false;
	}

	public function hapusData($id)
	{
		$this->db->where('md5(id_mustahik)', verify($id));
		$this->db->delete('tb_mustahik');
		return ($this->db->affected_rows() === 1) ? true : false;
	}
}

/* End of file db_mustahik_m.php */
/* Location: ./application/models/db_mustahik_m.php */