<?php

namespace  App\Modules\video\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;

class Video extends BaseController
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
		return view('App\Modules\Video\Views/video', [
			'title' => 'Video',
			'videoYoutube' => $this->setting->info['video_youtube'],
			'uploadSize' => '200 MB',
			'maxsizeInfo' => max_file_upload_in_bytes(),
		]);
	}

}
