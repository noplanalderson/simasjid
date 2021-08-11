<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {

	public function getAllUsers()
	{
		$this->db->select('a.user_id, a.user_name, a.real_name, a.user_email, a.is_active, b.nama_jabatan');
		$this->db->join('tb_jabatan b', 'a.id_jabatan = b.id_jabatan', 'inner');
		$this->db->where('a.user_id != ', $this->session->userdata('uid'));
		return $this->db->get('tb_user a')->result();
	}

	public function getJabatan()
	{
		$this->db->order_by('nama_jabatan', 'asc');
		return $this->db->get('tb_jabatan')->result();
	}

	public function tambahUser($data)
	{
		return $this->db->insert('tb_user', $data) ? $this->db->insert_id() : false;
	}

	public function getUserByID($id)
	{
		$this->db->select('user_name, user_email, real_name, id_jabatan, user_picture, is_active');
		$this->db->where('md5(user_id)', verify($id));
		return $this->db->get('tb_user')->row_array();
	}

	public function checkUser($username, $email, $mode = 'tambah', $id = NULL)
	{
		$this->db->select('user_name');
		if($mode == 'edit'){
			$this->db->group_start();
		}
		$this->db->where('user_name', $username);
		$this->db->or_where('user_email', $email);
		if($mode == 'edit'){
			$this->db->group_end();
			$this->db->where('md5(user_id) !=', verify($id));
		}
		return $this->db->get('tb_user')->num_rows();
	}

	public function editUser($data, $id)
	{
		$this->db->where('md5(user_id)', verify($id));
		$this->db->update('tb_user', $data);
		return ($this->db->affected_rows() === 1) ? true : false ;
	}

	public function hapusUser($id)
	{
		$this->db->where('md5(user_id)', verify($id));
		$this->db->delete('tb_user');
		return ($this->db->affected_rows() === 1) ? true : false ;
	}
}

/* End of file user_m.php */
/* Location: ./application/models/user_m.php */