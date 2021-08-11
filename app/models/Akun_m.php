<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_m extends CI_Model {

	public function getAkun()
	{
		$this->db->select('real_name, user_name, user_email');
		$this->db->where('user_id', $this->session->userdata('uid'));
		return $this->db->get('tb_user')->row();
	}

	public function updateAkun($akun)
	{
		$this->db->where('user_id', $this->session->userdata('uid'));
		return $this->db->update('tb_user', $akun) ? true : false;
	}

	public function ubahPassword($pwd)
	{
		$this->db->where('user_id', $this->session->userdata('uid'));
		return $this->db->update('tb_user', ['user_password' => $pwd]) ? true : false;
	}
}

/* End of file akun_m.php */
/* Location: ./application/models/akun_m.php */