<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilitas_m extends CI_Model {

	public function getKategori()
	{
		$this->db->order_by('kategori', 'asc');
		return $this->db->get('tb_kategori_kas')->result();
	}

	public function getJabatan()
	{
		$this->db->select('a.nama_jabatan, a.id_jabatan, b.type_name');
		$this->db->join('tb_user_type  b', 'a.type_id = b.type_id', 'inner');
		$this->db->order_by('a.nama_jabatan', 'asc');
		return $this->db->get('tb_jabatan a')->result();
	}

	public function getJenisKegiatan()
	{
		$this->db->order_by('jenis_kegiatan', 'asc');
		return $this->db->get('tb_jenis_kegiatan')->result();
	}

	public function getUserType()
	{
		$this->db->order_by('type_name', 'asc');
		return $this->db->get('tb_user_type')->result();
	}

	public function getKategoriByHash($hash)
	{
		$this->db->where('md5(id_kategori)', verify($hash));
		return $this->db->get('tb_kategori_kas')->row_array();
	}

	public function getJabatanByHash($hash)
	{
		$this->db->where('md5(id_jabatan)', verify($hash));
		return $this->db->get('tb_jabatan')->row_array();
	}

	public function getJenisKegiatanByHash($hash)
	{
		$this->db->where('md5(id_jenis)', verify($hash));
		return $this->db->get('tb_jenis_kegiatan')->row_array();
	}

	public function tambahKategori($post)
	{
		return $this->db->insert('tb_kategori_kas', ['kategori' => ucwords($post['kategori'])]) ? true : false;
	}

	public function tambahJabatan($post)
	{
		return $this->db->insert('tb_jabatan', [
			'type_id' => $post['type_id'],
			'nama_jabatan' => ucwords($post['nama_jabatan'])
		]) ? true : false;
	}

	public function tambahJenisKegiatan($post)
	{
		return $this->db->insert('tb_jenis_kegiatan', ['jenis_kegiatan' => ucwords($post['jenis_kegiatan'])]) ? true : false;
	}

	public function cekKategori($post)
	{
		$this->db->where('kategori', ucwords($post['kategori']));
		$this->db->where('md5(id_kategori) != ', verify($post['id_kategori']));
		return $this->db->get('tb_kategori_kas')->num_rows();
	}

	public function editKategori($post)
	{
		$this->db->where('md5(id_kategori)', verify($post['id_kategori']));
		return $this->db->update('tb_kategori_kas', [
			'kategori' => ucwords($post['kategori'])
		]) ? true : false;
	}

	public function cekJabatan($post)
	{
		$this->db->where('nama_jabatan', ucwords($post['nama_jabatan']));
		$this->db->where('md5(id_jabatan) != ', verify($post['id_jabatan']));
		return $this->db->get('tb_jabatan')->num_rows();
	}

	public function editJabatan($post)
	{
		$this->db->where('md5(id_jabatan)', verify($post['id_jabatan']));
		return $this->db->update('tb_jabatan', [
			'nama_jabatan' => ucwords($post['nama_jabatan']),
			'type_id' => $post['type_id']
		]) ? true : false;
	}

	public function cekJenisKegiatan($post)
	{
		$this->db->where('jenis_kegiatan', ucwords($post['jenis_kegiatan']));
		$this->db->where('md5(id_jenis) != ', verify($post['id_jenis']));
		return $this->db->get('tb_jenis_kegiatan')->num_rows();
	}

	public function editJenisKegiatan($post)
	{
		$this->db->where('md5(id_jenis)', verify($post['id_jenis']));
		return $this->db->update('tb_jenis_kegiatan', [
			'jenis_kegiatan' => ucwords($post['jenis_kegiatan'])
		]) ? true : false;
	}

	public function hapusKategori($hash)
	{
		$this->db->where('md5(id_kategori)', verify($hash));
		$this->db->delete('tb_kategori_kas');

		return ($this->db->affected_rows() == 1) ? true  : false;
	}

	public function hapusJabatan($hash)
	{
		$this->db->where('md5(id_jabatan)', verify($hash));
		$this->db->delete('tb_jabatan');

		return ($this->db->affected_rows() == 1) ? true  : false;
	}

	public function hapusJenisKegiatan($hash)
	{
		$this->db->where('md5(id_jenis)', verify($hash));
		$this->db->delete('tb_jenis_kegiatan');

		return ($this->db->affected_rows() == 1) ? true  : false;
	}
}

/* End of file utilitas_m.php */
/* Location: ./application/models/utilitas_m.php */