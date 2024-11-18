<?php

namespace App\Modules\Setting\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Setting\Models\SettingModel;
use App\Modules\Setting\Models\KotaModel;
use App\Modules\Setting\Models\ProvinsiModel;
use App\Modules\Layout\Models\LayoutModel;
use Pusher\Pusher;

class Setting extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = SettingModel::class;
    protected $kota;
    protected $provinsi;
    protected $layout;
    protected $pusher;

    public function __construct()
    {
        //memanggil Model
        $this->kota = new KotaModel();
        $this->provinsi = new ProvinsiModel();
        $this->layout = new LayoutModel();

        //Options Pusher
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
    }

    public function general()
    {
        return $this->respond(["status" => true, "message" => "Success", "data" => $this->model->where('group_setting', 'general')->findAll()], 200);
    }

    public function app()
    {
        return $this->respond(["status" => true, "message" => "Success", "data" => $this->model->where('group_setting', 'app')->findAll()], 200);
    }

    public function update($id = NULL)
    {
        $rules = [
            'value_setting' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'value_setting' => $json->value_setting,
            ];
        } else {
            $data = $this->request->getRawInput();
        }

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.updFailed'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $this->model->update($id, $data);

            // Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    //ID setting khusus untuk pusher layout, jadwal sholat, dan kota cuaca
                    if ($id == 8) {
                        $push['message'] = lang('App.refreshSuccess');
                        $push['event'] = 'layout';
                        $this->pusher->trigger('my-channel', 'my-event', $push);
                    } else if ($id == 15) {
                        $push['message'] = lang('App.refreshSuccess');
                        $push['event'] = 'sholat';
                        $this->pusher->trigger('my-channel', 'my-event', $push);
                    } else if ($id == 16) {
                        $push['message'] = lang('App.refreshSuccess');
                        $push['event'] = 'cuaca';
                        $this->pusher->trigger('my-channel', 'my-event', $push);
                    }
                }
            }

            $response = [
                'status' => true,
                'message' => lang('App.updSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function upload()
    {
        //Maksimal ukuran 51200 KB = 50 MB
        $rules = [
            'image' => [
                'rules'  => 'uploaded[image]|max_size[image,51200]|is_image[image]',
                'errors' => []
            ],
        ];

        $id = $this->request->getVar('id');
        $image = $this->request->getFile('image');
        $fileName = $image->getRandomName();
        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.imgFailed'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $path = "images/";
            $moved = $image->move($path, $fileName);
            if ($moved) {
                $simpan = $this->model->update($id, [
                    'value_setting' => $path . $fileName
                ]);
                if ($simpan) {
                    return $this->respond(["status" => true, "message" => lang('App.imgSuccess'), "data" => [$path . $fileName]], 200);
                } else {
                    return $this->respond(["status" => false, "message" => lang('App.imgFailed'), "data" => []], 200);
                }
            }
        }
    }

    public function kota()
    {
        return $this->respond(["status" => true, "message" => "Success", "data" => $this->kota->findAll()], 200);
    }

    public function getKota()
    {
        $input = $this->request->getVar();
        $select = $input['provinsi'];
        $data = $this->kota->where(['id_provinsi' => $select])->findAll();
        return $this->respond(["status" => true, "message" => "Success", "data" => $data], 200);
    }

    public function provinsi()
    {
        return $this->respond(["status" => true, "message" => "Success", "data" => $this->provinsi->findAll()], 200);
    }

    public function layout()
    {
        return $this->respond(["status" => true, "message" => "Success", "data" => $this->layout->findAll()], 200);
    }

    public function setChange($id = NULL)
    {
        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'value_setting' => $json->value_setting,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'value_setting' => $input['value_setting']
            ];
        }

        if ($data > 0) {
            $this->model->update($id, $data);
            // Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    //ID setting khusus untuk pusher layout, jadwal sholat, dan kota cuaca
                    if ($id == 8) {
                        $push['message'] = lang('App.refreshSuccess');
                        $push['event'] = 'layout';
                        $this->pusher->trigger('my-channel', 'my-event', $push);
                    } else if ($id == 15) {
                        $push['message'] = lang('App.refreshSuccess');
                        $push['event'] = 'sholat';
                        $this->pusher->trigger('my-channel', 'my-event', $push);
                    } else if ($id == 16) {
                        $push['message'] = lang('App.refreshSuccess');
                        $push['event'] = 'cuaca';
                        $this->pusher->trigger('my-channel', 'my-event', $push);
                    }
                }
            }

            $response = [
                'status' => true,
                'message' => lang('App.updSuccess'),
                'data' => []
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.updFailed'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }
}
