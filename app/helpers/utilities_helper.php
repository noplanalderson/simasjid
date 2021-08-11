<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Multiple Selected Function
 * 
 *
 * @access	public
 * @param 	string 	$cat
 * @param 	string 	$catList
 * @return	string	
 * 
*/
function multiple_selected($cat, $catList)
{
  $explodeCat = explode(", ", $catList);
  
  return in_array($cat, $explodeCat) ?: "selected";
}

/**
 * Indonesian Date Function
 * 
 *
 * @access  public
 * @param   string  $date
 * @param   bool  $print_day
 * @param   bool  $time
 * @param   string $timezone
 * @return  string  
 * 
*/
function indonesian_date($date, $print_day = FALSE, $time = FALSE, $timezone = 'WIB')
{
  $day = array ( 1 =>    'Senin',
      'Selasa',
      'Rabu',
      'Kamis',
      'Jumat',
      'Sabtu',
      'Minggu'
    );

  $month = array (1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );

  if(preg_match('/^\d+$/', $date)) 
  {
    if($time === true)
    {
      $date = date('Y-m-d H:i:s', $date);

      $split = explode('-', $date);
      $time = explode(' ', $split[2]);
      $indo_date = $time[0] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0] . ' - ' . $time[1] . ' ' . $timezone;
    }
    else
    {
      $date = date('Y-m-d', $date);

      $split = explode('-', $date);
      $indo_date = $split[2] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0];
    }

    if ($print_day) {
      $num = date('N', strtotime($date));
      return $day[$num] . ', ' . $indo_date;
    }

    return $indo_date;
  }
  elseif(empty($date))
  {
    return '-';
  }
  else
  {
    if($time ===  true)
    {
      $split = explode('-', $date);
      $time = explode(' ', $split[2]);
      $indo_date = $time[0] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0] . ' - ' . $time[1] . ' ' . $timezone;
    }
    else
    {
      $split = explode('-', $date);
      $time = explode(' ', $split[2]);
      $indo_date = $time[0] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0];
    }

    if ($print_day) {
      $num = date('N', strtotime($date));
      return $day[$num] . ', ' . $indo_date;
    }

    return $indo_date;
  }
}

/**
 * Indonesian Month Function
 * 
 *
 * @access  public
 * @param   string  $date
 * @param   string $type
 * @return  string  
 * 
*/
function indonesian_month($date, $type = 'STANDAR')
{
  switch ($type) {
    case 'ROME':
      $month = array (
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10=> 'X',
        11=> 'XI',
        12=> 'XII'
      );
      
      $split = explode('-', $date);
      $month_format = $month[ (int)$split[1] ];
      
      break;
    
    default:
      $month = array (
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10=> 'Oktober',
        11=> 'November',
        12=> 'Desember'
      );
      
      $split = explode('-', $date);
      $month_format = $month[ (int)$split[1] ].' '.$split[0];

      break;
  }

  return $month_format;
}

function remove_dir($dir)
{
  if(is_dir($dir))
  {
      foreach(scandir($dir) as $file) {
          if ('.' === $file || '..' === $file) continue;
          if (is_dir("$dir/$file")) remove_dir("$dir/$file");
          else @unlink("$dir/$file");
      }
      return (bool) @rmdir($dir);
  }
}

function rupiah($angka, $rp = true){
  
  $hasil_rupiah = number_format($angka,2,'.',',');
  $hasil_rupiah = ($rp === true) ? "Rp. " . $hasil_rupiah : $hasil_rupiah;
  return $hasil_rupiah;
 
}

function teaser($input, $length = 200)
{
  if( strlen($input) <= $length )
    return $input;

  $parts = explode(" ", $input);

  while( strlen( implode(" ", $parts) ) > $length )
    array_pop($parts);

  return implode(" ", $parts);
}