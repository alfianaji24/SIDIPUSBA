<?php

namespace App\Modules\Layout\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Layout\Models\LayoutModel;
use App\Libraries\Settings;

class Layout extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = LayoutModel::class;
    protected $setting;

    public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
	}

    public function index()
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->findAll()], 200);
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->find($id)], 200);
    }
}
