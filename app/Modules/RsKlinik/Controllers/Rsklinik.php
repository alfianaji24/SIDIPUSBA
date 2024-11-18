<?php

namespace  App\Modules\RsKlinik\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;
use App\Modules\RsKlinik\Models\JampelayananModel;

class Rsklinik extends BaseController
{
	protected $setting;
	protected $jam;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		$this->jam = new JampelayananModel();
		//memanggil Helper
		helper('disfo');
	}

	public function dokter()
	{
		return view('App\Modules\RsKlinik\Views/dokter', [
			'title' => 'Dokter',
			'uploadSize' => '50 MB',
			'maxsizeInfo' => max_file_upload_in_bytes(),
		]);
	}

	public function ruangan()
	{
		return view('App\Modules\RsKlinik\Views/ruangan', [
			'title' => 'Ruangan Periksa'
		]);
	}

	public function hariLayanan()
	{
		return view('App\Modules\RsKlinik\Views/harilayanan', [
			'title' => 'Setup Hari Layanan',
			'dataJam' => $this->jam->orderBy('jam_ke','ASC')->findAll(),
		]); 
	}

	public function jamPelayanan()
	{
		return view('App\Modules\RsKlinik\Views/jampelayanan', [
			'title' => 'Jam Pelayanan'
		]);
	}

	public function jadwalDokter()
	{
		return view('App\Modules\RsKlinik\Views/jadwaldokter', [
			'title' => 'Jadwal Dokter'
		]);
	}

}
