<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_m extends CI_Model {

	public function getLogKas($start, $end)
	{
		$this->db->select('a.log_id, a.timestamp, a.aksi, a.kode_transaksi, a.date, a.keterangan, a.pemasukan, a.pengeluaran, b.real_name, c.kategori');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->join('tb_kategori_kas c', 'a.id_kategori = c.id_kategori', 'left');
		$this->db->where("UNIX_TIMESTAMP(a.timestamp) BETWEEN '$start' AND '$end'");
		$this->db->order_by('a.timestamp', 'desc');
		return ['response' =>  $this->db->get('tb_log_kas a')->result()];
	}

	public function getLogZakatFitrah($start, $end)
	{
		$this->db->select('a.log_id, a.timestamp, a.aksi, a.status, a.date, a.bentuk_zakat, a.satuan_zakat, a.kode_transaksi, a.atas_nama, a.jumlah_jiwa, a.jumlah_zakat, b.real_name');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->where("UNIX_TIMESTAMP(a.timestamp) BETWEEN '$start' AND '$end'");
		$this->db->order_by('a.timestamp', 'desc');
		return ['response' => $this->db->get('tb_log_zakat_fitrah a')->result()];
	}

	public function getLogZakatMal($start, $end)
	{
		$this->db->select('a.log_id, a.timestamp, a.aksi, a.status, a.date, a.bentuk_zakat, a.satuan_zakat, a.kode_transaksi, a.atas_nama, a.jumlah_jiwa, a.jumlah_zakat, b.real_name');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->where("UNIX_TIMESTAMP(a.timestamp) BETWEEN '$start' AND '$end'");
		$this->db->order_by('a.timestamp', 'desc');
		return ['response' => $this->db->get('tb_log_zakat_mal a')->result()];
	}

	public function getLogInventaris($start, $end)
	{
		$this->db->select('a.log_id, a.timestamp, a.aksi, a.kode_barang, a.nama_barang, a.kuantitas_masuk, a.kuantitas_keluar, a.satuan, a.keterangan, b.real_name');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->where("UNIX_TIMESTAMP(a.timestamp) BETWEEN '$start' AND '$end'");
		$this->db->order_by('a.timestamp', 'desc');
		return ['response' => $this->db->get('tb_log_inventaris a')->result()];
	}
}

/* End of file audit_m.php */
/* Location: ./application/models/audit_m.php */