<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model {

	public function getKasMasjid()
	{
		$this->db->select('(SUM(pemasukan) - SUM(pengeluaran)) AS saldo');
		return $this->db->get('tb_kas_masjid')->row();
	}

	public function getZakatFitrahUang()
	{
		$this->db->select('
			((SELECT SUM(jumlah_zakat) FROM tb_zakat_fitrah WHERE status = "masuk" AND bentuk_zakat = "uang tunai") -
			(SELECT SUM(jumlah_zakat) FROM tb_zakat_fitrah WHERE status = "keluar" AND bentuk_zakat = "uang tunai")) AS sisa_zakat_fitrah');
		return $this->db->get('tb_zakat_fitrah')->row();
	}

	public function getZakatMalUang()
	{
		$this->db->select('
			((SELECT SUM(jumlah_zakat) FROM tb_zakat_mal WHERE status = "masuk" AND satuan_zakat = "RUPIAH") -
			(SELECT SUM(jumlah_zakat) FROM tb_zakat_mal WHERE status = "keluar" AND satuan_zakat = "RUPIAH")) AS sisa_zakat_mal');
		return $this->db->get('tb_zakat_mal')->row();
	}

	public function chartKas()
	{
		$sumberKas = [];
		$jumlah = [];

		$this->db->select('SUM(a.pemasukan) AS jumlah, b.kategori');
		$this->db->join('tb_kategori_kas b', 'a.id_kategori = b.id_kategori', 'left');
		$this->db->group_by('a.id_kategori');
		$sumber = $this->db->get('tb_kas_masjid a')->result();

		foreach ($sumber as $value) {
			$sumberKas[] = $value->kategori;
			$jumlah[] = $value->jumlah;
		}

		return array('labels' => $sumberKas, 'data' => ['jumlah' => $jumlah]);
	}

	public function transaksiTerakhir()
	{
		$this->db->select('a.keterangan, a.date, a.pemasukan, a.pemasukan, a.pengeluaran, b.kategori');
		$this->db->join('tb_kategori_kas b', 'a.id_kategori = b.id_kategori', 'left');
		$this->db->order_by('a.id_transaksi', 'desc');
		return $this->db->get('tb_kas_masjid a', 3)->result();
	}

	public function getAgendaToday()
	{
		$this->db->select('a.judul_kegiatan, a.tanggal, a.jam_mulai, a.jam_selesai, a.narasumber, b.jenis_kegiatan');
		$this->db->join('tb_jenis_kegiatan b', 'a.id_jenis = b.id_jenis', 'inner');
		$this->db->where('a.tanggal', date('Y-m-d'));
		$this->db->order_by('a.jam_mulai', 'desc');
		return $this->db->get('tb_kegiatan a')->result();
	}

	public function getStokBarang()
	{
		$this->db->select('satuan, nama_barang, tgl_pendataan, (SUM(kuantitas_masuk) - SUM(kuantitas_keluar)) AS stok');
		$this->db->group_by('nama_barang');
		$this->db->order_by('(SUM(kuantitas_masuk) - SUM(kuantitas_keluar))', 'desc');
		return $this->db->get('tb_inventaris', 5)->result();
	}
}

/* End of file dashboard_m.php */
/* Location: ./application/models/dashboard_m.php */