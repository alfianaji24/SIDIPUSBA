<?php

namespace App\Modules\Ruang\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Ruang\Models\RuangModel;

class Ruang extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = RuangModel::class;

    public function index()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->findAll()], 200);
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->find($id)], 200);
    }

    public function kampus()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->where('jenis_ruang', 'kampus')->findAll()], 200);
    }

    public function sekolah()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->where('jenis_ruang', 'sekolah')->findAll()], 200);
    }

    public function rsklinik()
    {
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $this->model->where('jenis_ruang', 'rsklinik')->findAll()], 200);
    }

    public function create()
    {
        $rules = [
            'nama_ruang' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jenis_ruang' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'nama_ruang' => $json->nama_ruang,
                'jenis_ruang' => $json->jenis_ruang,
            ];
        } else {
            $data = [
                'nama_ruang' => $this->request->getPost('nama_ruang'),
                'jenis_ruang' => $this->request->getPost('jenis_ruang'),
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
            'nama_ruang' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'nama_ruang' => $json->nama_ruang,
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

            $response = [
                'status' => true,
                'message' => lang('App.updSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
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

    public function updateRuang($id = NULL)
    {
        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'id_ruang' => $json->id_ruang,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'id_ruang' => $input['id_ruang'],
            ];
        }

        if ($data > 0) {
            $this->model->update($id, $data);
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
