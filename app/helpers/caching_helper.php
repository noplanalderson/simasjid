<?php
/**
 * Caching Helper
 *
 *
 * Load data from memcached if exist
 * If cache is empty, load data from model
 * 
 * @access	public
 * 
 * @param	string	index
 * @param 	string 	model
 * @param 	string 	method
 * @param 	string|int|null 	value
 * @param 	int 	expire
 *  	
 * @return	mixed
 *  
*/
defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('load_cache'))
{
	function load_cache($index = '', $model = '', $method = '', $value = NULL, $expire = 3600)
	{
		$CI =& get_instance();
		$value = (is_null($value) || !is_array($value)) ? [$value] : $value;

		$CI->load->model($model);
		
		if($CI->cache->get($index))
		{
			$object = $CI->cache->get($index);
		}
		else
		{
			$object = call_user_func_array([$CI->$model, $method], $value);
			$CI->cache->save($index, $object, $expire);
		}

		return $object;
	}
}