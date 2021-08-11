<?php
/*--------------------------------------------------------
 | Assets Helper
 |--------------------------------------------------------
 |
 | Used to called needed assets such css, js, and image
 | 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('css'))
{
	function css($str = '', $ext = 'css', $attr = 'rel="stylesheet"')
	{
		return '<link href="'.site_url('_/css/'.$str.'.'.$ext).'" '.$attr.'/>';		
	}
}

if (! function_exists('js'))
{
	function js($str = '', $ext = 'js', $attr = NULL)
	{
		return '<script src="'.site_url('_/js/'.$str.'.'.$ext).'" '.$attr.'></script>';		
	}
}

if (! function_exists('show_image'))
{
	function show_image($str = '', $type = 'image', $attr = 'alt="image"')
	{
		switch ($type) {
			case 'icon':
				return '<link rel="shortcut icon" href="'.site_url('_/uploads/' . $str).'">';
			break;
			
			default:
				return '<img src="'.site_url('_/uploads/' . $str).'" '.$attr.'>';	
			break;
		}
	}
}

if (! function_exists('plugin'))
{
	function plugin($str = '', $type = 'css', $attr = NULL)
	{
		switch ($type) {
			case 'css':
				return '<link rel="stylesheet" href="'.site_url('_/vendors/'.$str.'.'.$type).'" '.$attr.'/>';
			break;
			
			default:
				return '<script src="'.site_url('_/vendors/'.$str.'.'.$type).'" '.$attr.'></script>';
			break;
		}		
	}
}