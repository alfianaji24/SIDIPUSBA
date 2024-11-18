<?php

namespace App\Modules\RsKlinik\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\RsKlinik\Models\JampelayananModel;
use App\Libraries\Settings;

class Jampelayanan extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = JampelayananModel::class;
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

    public function display()
    {
        $hasil['id_jam'] = 0;
        $hasil['jam_ke'] = "";
        $hasil['range_jam'] = "";
        $jampel = $this->model->findAll();

        foreach ($jampel as $jam) {
            $start = strtotime($jam['mulai']);
            $end = strtotime($jam['selesai']);
            if (time() >= $start && time() <= $end) {
                $hasil['id_jam'] = $jam['id'];
                $hasil['jam_ke'] = $jam['jam_ke'];
                $hasil['range_jam'] = $jam['mulai'] . "-" . $jam['selesai'];
                break;
            }
        }
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $hasil], 200);
    }

    public function create()
    {
        $rules = [
            'jam_ke' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'mulai' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'selesai' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'jam_ke' => $json->jam_ke,
                'mulai' => $json->mulai,
                'selesai' => $json->selesai,
            ];
        } else {
            $data = [
                'jam_ke' => $this->request->getPost('jam_ke'),
                'mulai' => $this->request->getPost('mulai'),
                'selesai' => $this->request->getPost('selesai'),
            ];
        }

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.isRequired'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            //save ke tabel
            $this->model->save($data);
            $response = [
                'status' => true,
                'message' => lang('App.saveSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function update($id = NULL)
    {
        $rules = [
            'jam_ke' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'mulai' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'selesai' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'jam_ke' => $json->jam_ke,
                'mulai' => $json->mulai,
                'selesai' => $json->selesai,
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
            $simpan = $this->model->update($id, $data);
            if ($simpan) {
                $response = [
                    'status' => true,
                    'message' => lang('App.updSuccess'),
                    'data' => [],
                ];
                return $this->respond($response, 200);
            }
        }
    }

    public function delete($id = null)
    {
        $hapus = $this->model->find($id);
        if ($hapus) {
            $this->model->delete($id);
            $response = [
                'status' => true,
                'message' => lang('App.delSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.delFailed'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }
}
