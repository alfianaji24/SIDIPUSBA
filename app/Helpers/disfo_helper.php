<?php

function hari($day)
{
	switch ($day) {
		case 'Sun':
			$hari_ini = "Minggu";
			break;

		case 'Mon':
			$hari_ini = "Senin";
			break;

		case 'Tue':
			$hari_ini = "Selasa";
			break;

		case 'Wed':
			$hari_ini = "Rabu";
			break;

		case 'Thu':
			$hari_ini = "Kamis";
			break;

		case 'Fri':
			$hari_ini = "Jumat";
			break;

		case 'Sat':
			$hari_ini = "Sabtu";
			break;

		default:
			$hari_ini = "Tidak di ketahui";
			break;
	}

	return $hari_ini;
}

function kegiatan($num)
{
	switch ($num) {
		case 1:
			$hari_ini['id'] = "Upacara";
			$hari_ini['ket'] = "Upacara Bendera Setiap Hari Senin";
			break;

		case 2:
			$hari_ini['id'] = "KBM";
			$hari_ini['ket'] = "Kegiatan Belajar Mengajar";
			break;

		case 3:
			$hari_ini['id'] = "Istirahat";
			$hari_ini['ket'] = "Waktunya Istirahat";
			break;

		case 4:
			$hari_ini['id'] = "Imtaq";
			$hari_ini['ket'] = "Kegiatan Penguatan Iman dan Taqwa";
			break;

		case 5:
			$hari_ini['id'] = "Senam";
			$hari_ini['ket'] = "Kegiatan Kebugaran Jasmani";
			break;

		case 6:
			$hari_ini['id'] = "Bersih-bersih";
			$hari_ini['ket'] = "Kegiatan Membersihkan Lingkungan Sekolah";
			break;
		case 7:
			$hari_ini['id'] = "Kegiatan Lainnya";
			$hari_ini['ket'] = "Kegiatan Kokurikuler / Pembiasaan Lainnya";
			break;
		default:
			$hari_ini['id'] = "";
			$hari_ini['ket'] = "";
			break;
	}

	return $hari_ini;
}

function layanan($num)
{
	switch ($num) {
		case 1:
			$hari_ini['id'] = "Libur";
			$hari_ini['ket'] = "Libur/Off";
			break;

		case 2:
			$hari_ini['id'] = "Buka";
			$hari_ini['ket'] = "Layanan Buka";
			break;

		case 3:
			$hari_ini['id'] = "Istirahat";
			$hari_ini['ket'] = "Waktunya Istirahat";
			break;
		default:
			$hari_ini['id'] = "";
			$hari_ini['ket'] = "";
			break;
	}

	return $hari_ini;
}

function return_bytes($val)
{
	$val = trim($val);
	$last = strtolower($val[strlen($val) - 1]);
	$val = (int)trim($val);
	switch ($last) {
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	}
	return $val;
}

function max_file_upload_in_bytes()
{
	//select maximum upload size
	$max_upload = return_bytes(ini_get('upload_max_filesize'));
	//select post limit
	$max_post = return_bytes(ini_get('post_max_size'));
	//select memory limit
	$memory_limit = return_bytes(ini_get('memory_limit'));
	// return the smallest of them, this defines the real limit
	$upload_mb = min($max_upload, $max_post, $memory_limit);
	return number_format(ceil($upload_mb / 1000)).' MB';
}

function getIPAddress()
{
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}

    return $ipaddress;
}