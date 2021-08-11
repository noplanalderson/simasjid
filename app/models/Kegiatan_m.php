<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan_m extends CI_Model {

	public function getAgenda()
	{
		$this->db->select('a.id_kegiatan, a.tanggal, a.jam_mulai, a.jam_selesai, a.judul_kegiatan, a.narasumber, a.keterangan, b.jenis_kegiatan');
		$this->db->join('tb_jenis_kegiatan b', 'a.id_jenis = b.id_jenis', 'left');
		$this->db->order_by('a.tanggal', 'desc');
		return $this->db->get('tb_kegiatan a')->result();
	}

	public function getJenisAgenda()
	{
		$this->db->order_by('jenis_kegiatan', 'asc');
		return $this->db->get('tb_jenis_kegiatan')->result();
	}

	public function getAgendaByHash($hash)
	{
		$this->db->where('md5(id_kegiatan)', verify($hash));
		return $this->db->get('tb_kegiatan')->row_array();
	}

	public function tambahAgenda($data)
	{
		return $this->db->insert('tb_kegiatan', $data) ? true : false;
	}

	public function editAgenda($data, $id)
	{
		$this->db->where('md5(id_kegiatan)', verify($id));
		return $this->db->update('tb_kegiatan', $data) ? true : false;
	}
}

/* End of file kegiatan_m.php */
/* Location: ./app/models/kegiatan_m.php */