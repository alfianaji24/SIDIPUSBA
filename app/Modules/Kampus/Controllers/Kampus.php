<?php

namespace  App\Modules\Kampus\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class Kampus extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		//memanggil Helper
		helper('disfo');
	}

	public function dosen()
	{
		return view('App\Modules\Kampus\Views/dosen', [
			'title' => 'Dosen',
			'uploadSize' => '50 MB',
			'maxsizeInfo' => max_file_upload_in_bytes(),
		]);
	}

	public function skripsi()
	{
		return view('App\Modules\Kampus\Views/skripsi', [
			'title' => 'Ujian Skripsi'
		]);
	}
}
