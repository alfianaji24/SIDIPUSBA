<?php

namespace App\Modules\Display\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Libraries\Settings;

class Display extends BaseControllerApi
{
    protected $format       = 'json';
    protected $setting;

    public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
	}

    public function layoutAktif()
    {
        return $this->respond(["status" => true, "message" => "Success", "data" => $this->setting->info['layout']], 200);
    }


}
