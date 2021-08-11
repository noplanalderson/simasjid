<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_m extends CI_Model {

	public function getMasjidSetting()
	{
		return $this->db->get('tb_pengaturan_masjid', 1)->row();
	}	

	public function getAdmin()
	{
		$this->db->where('id_jabatan', 1);
		return $this->db->get('tb_user')->num_rows();
	}

	public function insertMasjid($settings)
	{
		return $this->db->insert('tb_pengaturan_masjid', [
			'logo_masjid' => $settings['logo_masjid'],
			'icon_masjid' => $settings['icon_masjid'],
			'nama_masjid' => ucwords($settings['nama_masjid']),
			'alamat_masjid' => $settings['alamat_masjid'],
			'telepon_masjid'=> $settings['telepon_masjid'],
			'email_masjid'=> $settings['email_masjid']
		]) ? true : false;
	}

	public function tambahAdmin($admin)
	{
		return $this->db->insert('tb_user', $admin) ? $this->db->insert_id() : false;
	}
}

/* End of file config_m.php */
/* Location: ./application/models/config_m.php */