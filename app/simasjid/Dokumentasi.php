<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumentasi extends SIMASJID_Core {

	public function __construct()
	{
		parent::__construct();
		$this->access_control->check_login();
		$this->access_control->check_role();

		$this->load->model('dokumentasi_m');
	}

	public function index()
	{
		if(isset($_POST['submit']))
		{
			$start 		= strtotime($this->input->post('start', TRUE));
			$end 		= strtotime($this->input->post('end', TRUE));
			$kegiatan	= $this->input->post('kegiatan', TRUE);

			$this->form_validation->set_rules('kegiatan', 'Judul Kegiatan', 
				'trim|regex_match[/[a-zA-Z0-9 @#$%&(\-_+)\'!?.,]+$/]', array(
					'regex_match' => '{field} hanya boleh mengandung karakter [a-zA-Z0-9 @#$%&(\-_+)\'!?.,].'
				)
			);

			if ($this->form_validation->run() == TRUE) 
			{
				$data = $this->dokumentasi_m->getDokumentasi($start, $end, $kegiatan);
				$msg  = 'Ditemukan '.count($data).' dokumentasi berdasarkan hasil pencarian.';
			} 
			else 
			{
				$data = [];
				$msg  = validation_errors();
			}

			$token 	= array('token' => $this->security->get_csrf_hash());
			$result = array_merge($token, ['response' => $data]);

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		else
		{
			$this->css_plugin = array(
				'fontawesome/css/all.min',
				'mdi/css/materialdesignicons.min',
				'daterangepicker/daterangepicker',
				'fileinput/css/fileinput.min',
				'lightGallery/dist/css/lightgallery-bundle.min',
				'lightGallery/dist/css/justified.gallery'
			);

			$this->js_plugin = array(
				'momentjs/moment.min',
				'momentjs/moment-timezone',
				'momentjs/moment-timezone-with-data',
				'daterangepicker/daterangepicker',
				'fileinput/js/fileinput.min',
				'fileinput/js/plugins/piexif.min',
				'fileinput/js/plugins/sortable.min',
				'fileinput/themes/fas/theme.min',
				'lightGallery/dist/lightgallery.umd',
				'lightGallery/dist/plugins/zoom/lg-zoom.umd',
				'lightGallery/dist/plugins/justified.Gallery',
				'lightGallery/dist/plugins/thumbnail/lg-thumbnail.umd',
				'lightGallery/dist/plugins/autoplay/lg-autoplay.umd',
				'lightGallery/dist/plugins/rotate/lg-rotate.umd',
				'lightGallery/dist/plugins/fullscreen/lg-fullscreen.umd',
				'lightGallery/dist/plugins/share/lg-share.umd',
				'lightGallery/dist/lightgallery.min',
			);

			$this->_partial = array(
				'head',
				'sidebar',
				'navbar',
				'body',
				'footer',
				'script'
			);

			$this->_module 	= 'dokumentasi/dokumentasi_view';
			
			$this->js 		= 'halaman/dokumentasi';
			
			$this->_data 	= array(
				'title' 	=> 'SIMASJID - Dokumentasi Kegiatan',
				'btn_del' 	=> $this->app_m->getContentMenu('hapus-foto'),
				'btn_upload'=> $this->app_m->getContentMenu('unggah-foto')
			);

			$this->load_view();

		}
	}

	public function unggah_foto()
	{
		$id = $this->input->post('id', TRUE);

		$this->form_validation->set_rules('id', 'ID', 'required|integer');

		if ($this->form_validation->run() == TRUE)
		{
			if(!empty($_FILES['dokumentasi']['name']))
			{
				$filesCount = count($_FILES['dokumentasi']['name']);

	            for($i = 0; $i < $filesCount; $i++)
	            {
	                $_FILES['file']['name']     = $_FILES['dokumentasi']['name'][$i];
	                $_FILES['file']['type']     = $_FILES['dokumentasi']['type'][$i];
	                $_FILES['file']['tmp_name'] = $_FILES['dokumentasi']['tmp_name'][$i];
	                $_FILES['file']['error']    = $_FILES['dokumentasi']['error'][$i];
	                $_FILES['file']['size']     = $_FILES['dokumentasi']['size'][$i];

					// Get Image's filename without extension
					$filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);

					// Remove another character except alphanumeric, space, dash, and underscore in filename
					$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

					// Remove space in filename
					$filename = str_replace(' ', '-', $filename);

					//User temp
					$usertemp = FCPATH . '_/uploads/dokumentasi/tmp';

					// Userdir
					$userdir  = FCPATH . '_/uploads/dokumentasi/'.date('Y/m');

					$config = array(
						'form_name' => 'file', // Form upload's name
						'upload_path' => $usertemp, // Upload Directory. Default : ./uploads
						'allowed_types' => 'png|jpg|jpeg|webp', // Allowed Extension
						'max_size' => '5128', // Maximun image size. Default : 5120
						'detect_mime' => TRUE, // Detect image mime. TRUE|FALSE
						'file_ext_tolower' => TRUE, // Force extension to lower. TRUE|FALSE
						'overwrite' => TRUE, // Overwrite file. TRUE|FALSE
						'enable_salt' => TRUE, // Enable salt for image's filename. TRUE|FALSE
						'file_name' => $filename, // New Image's Filename
						'extension' => 'webp', // New Imaage's Extension. Default : webp
						'quality' => '100%', // New Image's Quality. Default : 95%
						'maintain_ratio' => true, // Maintain image's dimension ratio. TRUE|FALSE
						'cleared_path' => $userdir
					);

					// Load Library
					$this->load->library('secure_upload');

					// Send library configuration
					$this->secure_upload->initialize($config);

					// Run Library
					if($this->secure_upload->doUpload())
					{
						// Get Image(s) Data
						$data = $this->secure_upload->data();

						//Create Thumbnail

                		$imageSize = @getimagesize($data['full_path']);

						$t_config['image_library'] 	= 'gd2';
						$t_config['source_image'] 	= $data['full_path'];
						$t_config['create_thumb'] 	= TRUE;
						$t_config['quality']		= '95%';
						$t_config['maintain_ratio'] = FALSE;
						$t_config['thumb_marker'] 	= '';
						$t_config['width']         	= 200;
						$t_config['height']       	= 200;
						$t_config['new_image']		= $userdir.'/thumbnail/';
						$t_config['y_axis']			= ($imageSize[1] - 200) / 2;
						$t_config['x_axis']			= ($imageSize[0] - 200) / 2;

						if (!is_dir($t_config['new_image'])) mkdir($t_config['new_image'], 0755, true);

                		$this->load->library('image_lib');
                		$this->image_lib->initialize($t_config);
                		if ( ! $this->image_lib->crop())
						{
							$error = true;
							$msg = $this->image_lib->display_errors();
						}
						else
						{
							$this->image_lib->clear();

							$error = ($this->dokumentasi_m->unggah($data['file_name'], $id) === true) ? null : true;
							$msg = ($error === true) ? 'Gagal mengunggah foto.' : 'Berhasil mengunggah foto.';
						}
					}
					else
					{
						$error = true;
						$msg = $this->secure_upload->show_errors();
					}
				}
			}
		}
		else
		{
			$error = true;
			$msg = 'ID Kegiatan tidak valid.';
		}

		$this->output->set_content_type('application/json')->set_output(json_encode([
			'error' => $error, 
			'msg' => $msg, 
			'token' => $this->security->get_csrf_hash()
		]));
	}

	public function get()
	{
		$post 	= $this->input->post(null, TRUE);
		
		$data 	= (!verify($post['id_kegiatan'])) ? [] : $this->dokumentasi_m->getDokumentasiByAgenda($post['id_kegiatan']);
		$token 	= array('token' => $this->security->get_csrf_hash());
		$result = array_merge($token, $data);

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hapus()
	{
		$hash 	= $this->input->post('key', TRUE);;
		$error 	= true;
		$msg 	= '';

		if(verify($hash) !== false)
		{
			$data = $this->dokumentasi_m->getFotoByHash($hash);
			
			if(!empty($data)) {
				
				if($this->dokumentasi_m->hapusFotoByHash($hash) == true) {
					
					@unlink(FCPATH .'/_/uploads/dokumentasi/'.$data['month'].'/'.$data['file_dokumentasi']);
					@unlink(FCPATH .'/_/uploads/dokumentasi/'.$data['month'].'/thumbnail/'.$data['file_dokumentasi']);

					$msg 	= 'Foto berhasil dihapus.';
					$error  = null;
				}
			}
		}
	
		$this->output->set_content_type('application/json')->set_output(json_encode([
			'error' => $error, 
			'msg' => $msg, 
			'token' => $this->security->get_csrf_hash()
		]));
	}
}