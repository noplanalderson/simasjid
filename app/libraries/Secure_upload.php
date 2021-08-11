<?php
defined('BASEPATH') OR die('No direct script access allowed.');

/**
 * Secure Upload Image for Codeigniter 3.x
 * This library combine Codeigniter 3's upload library and image_lib library
 * 
 * https://github.com/noplanalderson/ci_secure_upload.git
 * 
 * CI SECURE IMAGE UPLOADER is a library specially made for Codeigniter version 3.x.
 * The purpose of making this library is to ensure that images uploaded by users are free of malicious code 
 * that is created to hack servers or applications.
 * 
 * Find out how an image can run a malicious script please visit the following site:
 * 
 * - https://www.trustwave.com/en-us/resources/blogs/spiderlabs-blog/hiding-php-code-in-image-files-revisited/
 * - https://medium.com/@igordata/php-running-jpg-as-php-or-how-to-prevent-execution-of-user-uploaded-files-6ff021897389
 * 
 * @package Secure_upload.php
 * @author Muhammad Ridwan Na'im & Anrie 'Riesurya' Suryaningrat
 * @version 1.0
 * 
 */

class Secure_upload
{
	/**
	 * Form upload's name
	 * 
	 * @var string
	 */
	public $form_name = 'image';

	/**
	 * Upload Path
	 * 
	 * @var string
	 */
	public $upload_path = './uploads';

	/**
	 * Allowed image type to upload
	 * 
	 * @var string
	 */
	public $allowed_types = 'png|jpeg|jpg|gif|webp';

	/**
	 * Allowed maximum image size to upload
	 * 
	 * @var string
	 */
	public $max_size = '5120';

	/**
	 * Image filename
	 * 
	 * @var boolean
	 */
	public $file_name = '';

	/**
	 * Add Salt in filename
	 * 
	 * @var boolean
	 */
	public $enable_salt = TRUE;

	/**
	 * Overwrite uploaded file'
	 * 
	 * @var boolean
	 */
	public $overwrite = TRUE;

	/**
	 * New filename
	 * 
	 * @var string
	 */
	public $new_name = '';
	
	/**
	 * Uploaded Image Extension
	 * 
	 * @var string
	 */
	public $extension = 'webp';

	/**
	 * Force image extension to lower
	 * 
	 * @var boolean
	 */
	public $file_ext_tolower = TRUE;

	/**
	 * Detect Image mime
	 * 
	 * @var boolean
	 */
	public $detect_mime = TRUE;

	/**
	 * PHP Image Library to use
	 * 
	 * @var string
	 */
	public $image_library = 'gd2';

	/**
	 * Uploaded image (unclear)
	 * 
	 * @var string
	 */
	public $source_image = '';

	/**
	 * Image Quality after cleared
	 * 
	 * @var string
	 */
	public $quality = '95%';

	/**
	 * Maintain image dimension ratio
	 * 
	 * @var boolean
	 */
	public $maintain_ratio = TRUE;

	/**
	 * Image width after cleared
	 * 
	 * @var integer
	 */
	public $width = 800;

	/**
	 * Image height after cleared
	 * 
	 * @var integer
	 */
	public $height = 600;

	/**
	 * Path to cleared images
	 * 
	 * @var string
	 */
	public $cleared_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'cleared';

	/**
	 * Error Messages on Failure
	 * 
	 * @var array
	 */
	public $error_msg = array();
	
	/**
	 * Codeigniter Instance
	 * 
	 * @var object
	 */
	protected $_CI;

	/**
	 * Constructor
	 *
	 * @param	array	$config
	 * @return	void
	 */
	public function __construct($config = array())
	{
		empty($config) OR $this->initialize($config, FALSE);
		$this->_CI =& get_instance();

		log_message('info', 'Secure Upload Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @param	bool	$reset
	 * @return	Secure_upload
	 */
	public function initialize(array $config = array(), $reset = TRUE)
	{
		$reflection = new ReflectionClass($this);

		if ($reset === TRUE)
		{
			$defaults = $reflection->getDefaultProperties();
			foreach (array_keys($defaults) as $key)
			{
				if ($key[0] === '_')
				{
					continue;
				}

				if (isset($config[$key]))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($config[$key]);
					}
					else
					{
						$this->$key = $config[$key];
					}
				}
				else
				{
					$this->$key = $defaults[$key];
				}
			}
		}
		else
		{
			foreach ($config as $key => &$value)
			{
				if ($key[0] !== '_' && $reflection->hasProperty($key))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($value);
					}
					else
					{
						$this->$key = $value;
					}
				}
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	private function _salt()
	{
		$salt = base64_encode(openssl_random_pseudo_bytes(16));
		return preg_replace('~[^\\pL\d]+~u', '', $salt).'_'.random_string('alpha',8).'_'.random_string('nozero',4).'_'.random_string('numeric',9).'_'.random_string('alnum',6).'_'.time();
	}

	public function doUpload()
	{
		$this->new_name = ($this->enable_salt === TRUE) ? $this->file_name . '_' . $this->_salt() : $this->file_name;

		if (!is_dir($this->upload_path)) mkdir($this->upload_path, 0755, true);
		
		$config = [
			'upload_path' 	=> $this->upload_path,
			'allowed_types' => $this->allowed_types,
			'max_size' 		=> $this->max_size,
			'file_name' 	=> $this->new_name . '.' . $this->extension,
			'detect_mime'	=> $this->detect_mime
		];
		
		$this->_CI->load->library('upload');
		$this->_CI->upload->initialize($config);

		if($this->_CI->upload->do_upload($this->form_name))
		{
			$data = $this->_CI->upload->data();
			$this->source_image = $data['full_path'];

			return ( ! $this->_doClear()) ? true : false;
		}
		else
		{
			$this->error_msg = $this->_CI->upload->display_errors();
			return false;
		}
	}

	private function _doClear()
	{
		if($this->cleared_path == '')
		{
			$this->cleared_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'cleared';
		}

		if (!is_dir($this->cleared_path)) mkdir($this->cleared_path, 0755, true);

		$config = array(
			'image_library' => $this->image_library,
			'source_image' 	=> $this->source_image,
			'quality' 		=> $this->quality,
			'maintain_ratio'=> $this->maintain_ratio,
			'width' 		=> $this->width,
			'height' 		=> $this->height,
			'new_image' 	=> $this->cleared_path
		);

		$this->_CI->load->library('image_lib');
		$this->_CI->image_lib->initialize($config);

		if ( ! $this->_CI->image_lib->resize())
		{
			$this->error_msg = $this->_CI->image_lib->display_errors();
			return false;
		}

		$this->_CI->image_lib->clear();
		@unlink($this->source_image);
	}

	public function show_errors($prefix = '<p>', $suffix = '</p>')
	{
		if(is_array($this->error_msg))
		{
			foreach ($this->error_msg as $error) {
				return $prefix . $error . $suffix;
			}
		}
		else
		{
			return $prefix . $this->error_msg . $suffix;
		}
	}

	public function data()
	{
		$path = str_replace('\\', '/', $this->cleared_path.'/');
		$full_path = $path . '/' . $this->new_name.'.'.$this->extension;
		$filesize = filesize($full_path);

		return array(
			'file_name' => $this->new_name . '.' . $this->extension,
			'image_type' => $this->extension,
			'image_size_str' => array('width' => $this->width, 'height' => $this->height),
			'file_size' => round($filesize/1024, 0) . ' KB',
			'full_path' => $full_path,
			'cleared_path' => $path
		);
	}
}