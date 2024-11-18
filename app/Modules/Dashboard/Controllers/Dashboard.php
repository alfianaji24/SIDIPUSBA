<?php

namespace  App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Modules\Setting\Models\SettingModel;
use App\Libraries\Settings;

class Dashboard extends BaseController
{
	protected $setting;
	protected $settings;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		$this->settings = new SettingModel();
		//memanggil Helper
		helper('disfo');
	}


	public function index()
	{
		if ((env('PUSHER_APP_KEY') == "") && (env('PUSHER_APP_SECRET') == "") && (env('PUSHER_APP_ID') == "")) {
			$usePusher = $this->settings->where('variable_setting', 'use_pusher')->first();
			$idUsePusher = $usePusher['id'];
			$this->settings->update($idUsePusher, ['value_setting' => 'no']);
			redirect()->back()->with('success', 'PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID masih kosong di file .env, Setting use_pusher has been set to no');
		} else {
			$usePusher = $this->settings->where('variable_setting', 'use_pusher')->first();
			$idUsePusher = $usePusher['id'];
			$this->settings->update($idUsePusher, ['value_setting' => 'yes']);
			redirect()->back()->with('success', 'PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID sudah ada file .env, Setting use_pusher has been set to yes');
		}
		
		return view('App\Modules\Dashboard\Views/dashboard', [
			'title' => 'Dashboard',
			'maxsizeInfo' => max_file_upload_in_bytes(),
		]);
	}

}
