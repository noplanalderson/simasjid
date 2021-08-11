<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumentasi_m extends CI_Model {

	public function unggah($foto, $id)
	{
		return $this->db->insert('tb_dokumentasi', [
			'id_kegiatan' => $id,
			'user_id' => $this->session->userdata('uid'),
			'file_dokumentasi' => $foto
		]) ? true : false;
	}

	public function getDokumentasi($start, $end, $kegiatan)
	{
		$this->db->select('a.dok_id, a.file_dokumentasi, a.upload_date, a.dok_id, b.judul_kegiatan, b.tanggal, b.narasumber, b.keterangan, c.real_name');
		$this->db->join('tb_kegiatan b', 'a.id_kegiatan = b.id_kegiatan', 'left');
		$this->db->join('tb_user c', 'a.user_id = c.user_id', 'left');
		$this->db->where("UNIX_TIMESTAMP(b.tanggal) BETWEEN '$start' AND '$end'");
		if(!empty($kegiatan)) {
			$this->db->like('b.judul_kegiatan', $kegiatan, 'BOTH');
		}
		$this->db->order_by('b.tanggal', 'desc');
		return $this->db->get('tb_dokumentasi a')->result_array();
	}

	public function getDokumentasiByAgenda($id)
	{
		$this->db->select("a.dok_id, a.file_dokumentasi, date_format(a.upload_date, '%Y/%m') as month, b.judul_kegiatan");
		$this->db->join('tb_kegiatan b', 'a.id_kegiatan = b.id_kegiatan', 'left');
		$this->db->where('md5(a.id_kegiatan)', verify($id));
		$images = $this->db->get('tb_dokumentasi a')->result_array();

		$array 	= [];
		$json 	= [];

		foreach ($images as $image) {
			
			$json[] =  array(
				'caption' => $image['judul_kegiatan'],
				'width' => '200px',
				'url' => base_url('hapus-foto'),
				'key' => encrypt($image['file_dokumentasi'])
			);
		}

		foreach ($images as $image) {
			$array[] = site_url('_/uploads/dokumentasi/'.$image['month'].'/'.$image['file_dokumentasi']);
		}

		return ['array' => $array, 'json' => json_encode($json)];
	}

	public function getFotoByHash($hash)
	{
		$this->db->select("file_dokumentasi, date_format(upload_date, '%Y/%m') as month");
		$this->db->where('md5(file_dokumentasi)', verify($hash));
		return $this->db->get('tb_dokumentasi')->row_array();
	}

	public function hapusFotoByHash($hash)
	{
		$this->db->where('md5(file_dokumentasi)', verify($hash));
		$this->db->delete('tb_dokumentasi');
		return ($this->db->affected_rows() === 1) ? true : false;
	}
}

/* End of file dokumentasi_m.php */
/* Location: ./application/models/dokumentasi_m.php */