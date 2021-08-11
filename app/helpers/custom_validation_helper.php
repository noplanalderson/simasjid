<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Date Validation Function
 * 
 * Date validation using regex in ISO Format
 *
 * @access  public
 * @param   string  $date
 * @return  bool  
 * 
*/
function validate_date($date)
{
	return (bool) preg_match('/^((([1-9]\d{3})\-(0[13578]|1[02])\-(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})\-(0[13456789]|1[012])\-(0[1-9]|[12]\d|30))|(([1-9]\d{3})\-02\-(0[1-9]|1\d|2[0-8]))|(([1-9]\d(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\-02\-29))$/', $date);
}

/**
 * Timestamp Validation Function
 * 
 * Validate timestamp format
 *
 * @access  public
 * @param   integer  $timestamp
 * @return  int|bool  
 * 
*/
function isValidTimeStamp($timestamp)
{
    if(strlen($timestamp) === 10)
    {
        return ((string) (int) $timestamp === $timestamp) 
            && ($timestamp <= PHP_INT_MAX)
            && ($timestamp >= ~PHP_INT_MAX);
    }
    else
    {
        return false;
    }
}