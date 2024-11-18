<?php

namespace  App\Modules\Custom\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class Custom extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
	}


	public function index()
	{
		return view('App\Modules\Custom\Views/custom', [
			'title' => 'Custom'
		]);
	}

}
