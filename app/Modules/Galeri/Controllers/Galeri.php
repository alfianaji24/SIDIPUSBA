<?php

namespace  App\Modules\Galeri\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class Galeri extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		//memanggil Helper
		helper('disfo');
	}

	public function index()
	{
		return view('App\Modules\Galeri\Views/galeri', [
			'title' => 'Galeri',
			'uploadSize' => '50 MB',
			'maxsizeInfo' => max_file_upload_in_bytes(),
		]);
	}

}
