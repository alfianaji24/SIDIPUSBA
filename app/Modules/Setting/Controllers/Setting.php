<?php

namespace  App\Modules\Setting\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class Setting extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		//memanggil Helper
		helper('disfo');
	}

	public function general()
	{
		return view('App\Modules\Setting\Views/setting_general', [
			'title' => 'Pengaturan Umum',
			'uploadSize' => '50 MB',
			'maxsizeInfo' => max_file_upload_in_bytes(),
		]);
	}

	public function app()
	{
		return view('App\Modules\Setting\Views/setting_app', [
			'title' => 'Pengaturan Aplikasi',
			'provinsi' => $this->setting->info['provinsi'],
			'kota' => $this->setting->info['kota'],
			'uploadSize' => '50 MB',
			'maxsizeInfo' => max_file_upload_in_bytes(),
		]);
	}

}
