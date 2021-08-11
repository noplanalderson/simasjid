<?php
/**
 * Button Helper
 *
 *
 * Show user button or link based on user privilege
 * 
 * @access	public
 * 
 * @param	array	button
 * @param 	bool 	label
 * @param 	string 	mode
 * @param 	string|null 	attr
 *  	
 * @return	string
 *  
*/
defined('BASEPATH') OR exit('No direct script access allowed');

function button($button = [], $label = TRUE, $mode = 'a', $attr = NULL)
{
	if(!empty($button))
	{
		if($label)
		{
			return '<'.$mode.' '.$attr.'><i class="'.$button->menu_icon.'"></i> '.$button->menu_label.'</'.$mode.'>';
		}
		else
		{
			return '<'.$mode.' '.$attr.' title="'.$button->menu_label.'"><i class="'.$button->menu_icon.'"></i></'.$mode.'>';	
		}
	}
}