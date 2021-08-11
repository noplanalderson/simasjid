<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_m extends CI_Model {

	public function getMainMenu()
	{
		$this->db->select('a.menu_id, a.menu_label, a.menu_link, a.menu_icon');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.menu_location', 'mainmenu');
		$this->db->where('b.type_id', $this->session->userdata('gid'));
		$this->db->order_by('a.menu_id', 'asc');
		return $this->db->get('tb_menu a')->result();
	}

	public function getSubMenu($parent_id)
	{
		$this->db->select('a.menu_label, a.menu_link, a.menu_icon');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.menu_location', 'submenu');
		$this->db->where('a.menu_parent', $parent_id);
		$this->db->where('b.type_id', $this->session->userdata('gid'));
		$this->db->order_by('a.menu_id', 'asc');
		return $this->db->get('tb_menu a')->result();
	}

	public function getContentMenu($link)
	{
		$this->db->select('a.menu_label, a.menu_link, a.menu_icon');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.menu_location', 'content');
		$this->db->where('b.type_id', $this->session->userdata('gid'));
		$this->db->where('a.menu_link', $link);
		$this->db->order_by('a.menu_id', 'asc');
		return $this->db->get('tb_menu a')->row();
	}

	public function checkRole($menu, $gid)
	{
		$this->db->select('a.role_id');
		$this->db->join('tb_menu b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.type_id', $gid);
		$this->db->where('b.menu_link', $menu);
		return $this->db->get('tb_roles a')->num_rows();
	}

	public function getUserProfile()
	{
		$this->db->select("a.user_name, a.last_login, INET6_NTOA(a.last_ip) AS ip,
						   a.user_picture, a.real_name, b.nama_jabatan, c.index_page");
		$this->db->join('tb_jabatan b', 'a.id_jabatan = b.id_jabatan', 'inner');
		$this->db->join('tb_user_type c', 'b.type_id = c.type_id', 'inner');
		$this->db->where('a.user_id', $this->session->userdata('uid'));
		return $this->db->get('tb_user a')->row();
	}

	public function getAppSetting()
	{
		return $this->db->get('tb_pengaturan_masjid', 1)->row();
	}

	public function updateSettings($settingData)
	{
		return $this->db->update('tb_pengaturan_masjid', $settingData) ? true : false;
	}

	public function getActivityCategories()
	{
		return $this->db->get('tb_category_activity')->result();
	}

	public function uploadImage($index, $image)
	{
		return $this->db->update('tb_pengaturan_masjid', [$index => $image]) ? true : false;
	}

	public function updateSetting($data)
	{
		$data = array(
			'nama_masjid' => $data['nama_masjid'],
			'telepon_masjid' => $data['telepon_masjid'],
			'email_masjid' => $data['email_masjid']
		);

		return $this->db->update('tb_pengaturan_masjid', $data) ? true : false;
	}
}

/* End of file App_m.php */
/* Location: ./app/models/App_m.php */