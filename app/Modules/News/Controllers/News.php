<?php

namespace  App\Modules\News\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class News extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
	}

	public function index()
	{
		return view('App\Modules\News\Views/news', [
			'title' => 'News'
		]);
	}

}
