<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan_m extends CI_Model {

	public function getKategori()
	{
		$this->db->order_by('kategori', 'asc');
		return $this->db->get('tb_kategori_kas')->result();
	}

	public function getKas($opsi)
	{
		$this->db->select('a.kode_transaksi, a.keterangan, 
						   a.date, a.pemasukan, a.pengeluaran, 
						   b.kategori, c.real_name');
		$this->db->join('tb_kategori_kas b', 'a.id_kategori = b.id_kategori', 'inner');
		$this->db->join('tb_user c', 'a.user_id = c.user_id', 'left');
		($opsi === 'pemasukan') ? $this->db->where('a.pengeluaran IS NULL') : $this->db->where('a.pemasukan IS NULL');
		$this->db->order_by('date', 'desc');
		return $this->db->get('tb_kas_masjid a')->result();
	}

	public function getKasByKodeTransaksi($kode)
	{
		$this->db->select("*, CONCAT(date_format(date, '%Y/%m'), '/', dokumentasi) AS lokasi_file");
		$this->db->where('md5(kode_transaksi)', verify($kode));
		return $this->db->get('tb_kas_masjid')->row_array();
	}

	public function inputDataKas($data)
	{
		return $this->db->insert('tb_kas_masjid', $data) ? true : false;
	}

	public function editKas($data, $kode)
	{
		$this->db->where('md5(kode_transaksi)', verify($kode));
		return $this->db->update('tb_kas_masjid', $data) ? true : false;
	}

	public function hapusKas($kode)
	{
		$this->db->where('md5(kode_transaksi)', verify($kode));
		$this->db->delete('tb_kas_masjid');
		return ($this->db->affected_rows() === 1) ? true : false;
	}

	public function getLogs($kode)
	{
		$this->db->select('a.aksi, a.timestamp, a.date, 
						   a.keterangan, a.pemasukan, a.pengeluaran,
						   b.real_name, c.kategori');
		$this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
		$this->db->join('tb_kategori_kas c', 'c.id_kategori = a.id_kategori', 'inner');
		$this->db->where('md5(a.kode_transaksi)', verify($kode));
		$this->db->order_by('a.timestamp', 'asc');
		return $this->db->get('tb_log_kas a')->result_array();
	}

	private function _pengeluaran($id_kategori)
	{
		$this->db->select('SUM(pengeluaran) AS pengeluaran');
		$this->db->where('id_kategori', $id_kategori);
		$this->db->group_by('id_kategori');
		$keluar = $this->db->get('tb_kas_masjid')->row();

		return $keluar->pengeluaran;
	}

	public function getSaldoGroupByKategori()
	{
		$saldoKas = [];

		$this->db->select('a.id_kategori, SUM(a.pemasukan) AS saldo, b.kategori');
		$this->db->join('tb_kategori_kas b', 'a.id_kategori = b.id_kategori', 'inner');
		$this->db->where('a.pengeluaran IS NULL');
		$this->db->group_by('a.id_kategori');
		$saldo = $this->db->get('tb_kas_masjid a')->result();

		foreach ($saldo as $s) {
			$saldoKas[] = ['kategori' => $s->kategori, 'id_kategori' => $s->id_kategori, 'saldo' => $s->saldo - $this->_pengeluaran($s->id_kategori)];
		}

		return $saldoKas;
	}

	public function getSaldoKas()
	{
		$saldoKas = [];

		$this->db->select('a.id_kategori, a.date, SUM(a.pemasukan) AS saldo, b.kategori');
		$this->db->join('tb_kategori_kas b', 'a.id_kategori = b.id_kategori', 'inner');
		$this->db->where('a.pengeluaran IS NULL');
		$this->db->group_by('a.id_kategori');
		$saldo = $this->db->get('tb_kas_masjid a')->result();

		foreach ($saldo as $s) {
			$saldoKas[] = ['date' => $s->date, 'kategori' => $s->kategori, 'pemasukan' => $s->saldo, 'pengeluaran' => $this->_pengeluaran($s->id_kategori)];
		}

		return $saldoKas;
	}
}

/* End of file keuangan_m.php */
/* Location: ./application/models/keuangan_m.php */