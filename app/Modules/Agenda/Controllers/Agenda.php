<?php

namespace  App\Modules\Agenda\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class Agenda extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
	}


	public function index()
	{
		return view('App\Modules\Agenda\Views/agenda', [
			'title' => 'Agenda'
		]);
	}

}
