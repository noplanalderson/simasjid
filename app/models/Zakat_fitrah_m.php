<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zakat_fitrah_m extends CI_Model {

	public function getZakatFitrah($status)
	{
		$this->db->select('a.id_transaksi, a.kode_transaksi, a.date, a.atas_nama, 
						   a.alamat, a.no_telepon, a.bentuk_zakat, 
						   a.satuan_zakat, a.jumlah_jiwa, a.jumlah_zakat, b.real_name');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->where('a.status', $status);
		$this->db->order_by('a.date', 'desc');
		return $this->db->get('tb_zakat_fitrah a')->result();
	}

	public function tambahZakatFitrah($data)
	{
		return $this->db->insert('tb_zakat_fitrah', $data) ? true : false;
	}

	public function getZakatByKodeTransaksi($kode)
	{
		$this->db->where('md5(kode_transaksi)', verify($kode));
		return $this->db->get('tb_zakat_fitrah')->row_array();
	}

	public function editZakatFitrah($data, $kode)
	{
		$this->db->where('md5(kode_transaksi)', verify($kode));
		return $this->db->update('tb_zakat_fitrah', $data) ? true : false;
	}

	public function hapusZakatFitrah($kode)
	{
		$this->db->where('md5(kode_transaksi)', verify($kode));
		$this->db->delete('tb_zakat_fitrah');

		return ($this->db->affected_rows() === 1) ? true : false;
	}

	public function getLogs($kode)
	{
		$this->db->select('a.aksi, a.timestamp, a.date, a.status, a.atas_nama, 
						   a.bentuk_zakat, a.satuan_zakat, a.jumlah_jiwa, 
						   a.jumlah_zakat, b.real_name');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->where('md5(kode_transaksi)', verify($kode));
		return $this->db->get('tb_log_zakat_fitrah a')->result();
	}

	public function getDetailTransaksi($hash)
	{
		$this->db->select('a.kode_transaksi, a.date, a.atas_nama, a.status,
						   a.alamat, a.no_telepon, a.bentuk_zakat, 
						   a.satuan_zakat, a.jumlah_jiwa, a.jumlah_zakat, b.real_name');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->where('md5(a.kode_transaksi)', $hash);
		return $this->db->get('tb_zakat_fitrah a')->row();
	}

	public function rekapitulasiZakat()
	{
		$this->db->select('date, bentuk_zakat, satuan_zakat, SUM(jumlah_zakat) AS zakat_masuk');
		$this->db->where('status', 'masuk');
		$this->db->group_by('bentuk_zakat');
		return $this->db->get('tb_zakat_fitrah')->result();
	}

	public function rekapZakatKeluar($bentuk_zakat)
	{
		$this->db->select('SUM(jumlah_zakat) AS zakat_keluar');
		$this->db->where('bentuk_zakat', $bentuk_zakat);
		$this->db->where('status', 'keluar');
		$zakat = $this->db->get('tb_zakat_fitrah')->row();
		return $zakat->zakat_keluar;
	}
}

/* End of file zakat.php */
/* Location: ./application/models/zakat.php */