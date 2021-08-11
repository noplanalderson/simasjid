<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lupa_kata_sandi_m extends CI_Model {

	public function checkEmail($email)
	{
		$this->db->select('user_email');
		$this->db->where('user_email', $email);
		return $this->db->get('tb_user')->num_rows();
	}

	public function updateToken($email, $token)
	{
		$this->db->where('user_email', $email);
		return $this->db->update('tb_user', ['user_token' => $token, 'is_active' => 0]) ? true : false;
	}

}

/* End of file lupa_kata_sandi_m.php */
/* Location: ./application/models/lupa_kata_sandi_m.php */