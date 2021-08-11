<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Encrypt Function
 *
 *
 * Encrypt some string with md5(), explode, and shuffle
 * 
 * It will return result such: 
 * 
 * 		4b5ce2fe-8fd9-f2a7baf3-2830-eccbc87e
 * 
 * @access	public
 * @param 	string 	string
 * @return	string
 *  
*/
function encrypt($string)
{
	$hash  = md5($string);
	$blok1 = substr($hash, 0,8);
	$blok2 = substr($hash, 8,8);
	$blok3 = substr($hash, 16,4);
	$blok4 = substr($hash, 20,4);
	$blok5 = substr($hash, 24,8);

	return $blok2.'-'.$blok4.'-'.$blok5.'-'.$blok3.'-'.$blok1;
}

/**
 * Verify Function
 *
 *
 * Verify encrypted string with encrypt() function
 * It will return result as md5() hashing
 * 
 * @access	public
 * @param 	string 	string
 * @return	string|boolean
 *  
*/
function verify($string)
{
	$string = preg_replace("/[^a-z0-9\-]/", "", $string);
	if(strlen($string) == 36)
	{
		$hash = explode("-", $string);
		$hash = $hash[4].$hash[0].$hash[3].$hash[1].$hash[2];
		return $hash;
	}
	else
	{
		return false;
	}
}

/**
 * Random Character Function
 *
 *
 * Generate random characters or string
 * 
 * @access	public
 * @param 	int 	length
 * @return	boolean 	symbol
 *  
*/
function random_char($length = 16, $symbol = false)
{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($symbol) {
    	$chars .= '~!@#$%^&*()-_+?{}[]<|>?,.';
    }
    return substr(str_shuffle(str_repeat($chars, ceil($length/strlen($chars)) )), 0, $length);
}

/**
 * Base64 URL Encode
 *
 * 
 * Encode data to Base64URL
 * Replacing “+” with “-”, “/” with “_”, and remove padding character from the end of line
 * 
 * @param string $data
 * @return boolean|string
 * 
*/
function base64url_encode($data)
{
  // First of all you should encode $data to Base64 string
  $b64 = base64_encode($data);

  // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
  if ($b64 === false) {
    return false;
  }

  // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
  $url = strtr($b64, '+/', '-_');

  // Remove padding character from the end of line and return the Base64URL result
  return rtrim($url, '=');
}

/**
 * Base64 URL Decode
 *
 * 
 * Decode data from Base64URL
 * 
 * @param string $data
 * @param boolean $strict
 * @return boolean|string
 * 
*/
function base64url_decode($data, $strict = false)
{
  // Convert Base64URL to Base64 by replacing “-” with “+” and “_” with “/”
  $b64 = strtr($data, '-_', '+/');

  // Decode Base64 string and return the original data
  return base64_decode($b64, $strict);
}

/**
 * Password Hash Function
 *
 * 
 * Hashing Password Method
 * 
 * @param string $paintext
 * @param array|null $param
 * @return string
 * 
*/
function passwordHash($plaintext, $param = FALSE)
{
	if (version_compare(PHP_VERSION, '7.3', '>='))
	{
		return password_hash($plaintext, PASSWORD_ARGON2ID, $param);
	}
	elseif(version_compare(PHP_VERSION, '7.2', '<='))
	{
		return password_hash($plaintext, PASSWORD_ARGON2I, $param);
	}
	else
	{
		return password_hash($plaintext, PASSWORD_DEFAULT);
	}
}

/**
 * Encode Image Function
 *
 * 
 * Convert and show image to base64 encoding
 * 
 * @param string $path
 * @return string
 * 
*/
function encodeImage($path)
{
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = @file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

	return $base64;
}

/**
 * Hash Generator Function
 *
 * 
 * Create two way hashing with SODIUM_CRYPTO
 * 
 * @param string $str
 * @param string $key
 * @return string
 * 
*/
function hash_generator($str, $key)
{
  $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
  $ciphertext = sodium_crypto_secretbox($str, $nonce, $key);

  return $nonce . $ciphertext;
}

/**
 * Hash Unbox Function
 *
 * 
 * Unboxing Hash with Key
 * 
 * @param string $hash
 * @param string $key
 * @return string
 * 
*/
function hash_unbox($hash, $key)
{
  $nonce = mb_substr($hash, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
  $ciphertext = mb_substr($hash, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
  return sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
}
