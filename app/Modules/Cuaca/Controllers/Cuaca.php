<?php

namespace  App\Modules\Cuaca\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class Cuaca extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
	}


	public function index()
	{
		return view('App\Modules\Cuaca\Views/cuaca', [
			'title' => 'Prakiraan Cuaca',
			'provinsi' => $this->setting->info['provinsi'],
			'kota' => $this->setting->info['kota'],
		]);
	}

}
