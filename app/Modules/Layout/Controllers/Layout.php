<?php

namespace  App\Modules\Layout\Controllers;

use App\Controllers\BaseController;
use App\Modules\Layout\Models\LayoutModel;
use App\Libraries\Settings;

class Layout extends BaseController
{
	protected $layout;
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->layout = new LayoutModel();
		$this->setting = new Settings();
	}


	public function index()
	{
		$nama_layout = $this->setting->info['layout'];
		$layout = $this->layout->where('value', $nama_layout)->first();
		$id_layout = $layout['id']; 
		return view('App\Modules\Layout\Views/layout', [
			'title' => 'Layout DISFO',
			'active' => $id_layout-1,
		]);
	}

}
