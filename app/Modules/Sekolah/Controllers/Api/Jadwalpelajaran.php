<?php

namespace App\Modules\Sekolah\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Sekolah\Models\JadwalpelajaranModel;
use App\Libraries\Settings;

class Jadwalpelajaran extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = JadwalpelajaranModel::class;
    protected $setting;

    public function __construct()
    {
        //memanggil Model
        $this->setting = new Settings();
    }

    public function index()
    {
        $input = $this->request->getVar();
        $hari = $input['hari'];
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->getJadwalpelajaran($hari)], 200);
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->find($id)], 200);
    }

    public function display()
    {
        $input = $this->request->getVar();
        $hari = $input['hari'];
        $jamKe = $input['jam_ke'];
        $query = $this->model->guruMengajar($jamKe, $hari);
        if (!empty($query)) {
            $data = $query;
        } else {
            $data = ['error' => "Tidak ada kegiatan belajar mengajar pada jam ini."];
        }
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $data], 200);
    }

    public function display2()
    {
        $senin = $this->model->getJadwalpelajaran('senin');
        $selasa = $this->model->getJadwalpelajaran('selasa');
        $rabu = $this->model->getJadwalpelajaran('rabu');
        $kamis = $this->model->getJadwalpelajaran('kamis');
        $jumat = $this->model->getJadwalpelajaran('jumat');
        $sabtu = $this->model->getJadwalpelajaran('sabtu');

        $data = [
            'senin' => $senin,
            'selasa' => $selasa,
            'rabu' => $rabu,
            'kamis' => $kamis,
            'jumat' => $jumat,
            'sabtu' => $sabtu,
        ];

        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $data], 200);
    }

    public function create()
    {
        $rules = [
            'id_kelas' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jam_ke' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'hari' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'id_guru' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'id_kelas' => $json->id_kelas,
                'jam_ke' => $json->jam_ke,
                'hari' => $json->hari,
                'id_guru' => $json->id_guru,
            ];
        } else {
            $data = [
                'id_kelas' => $this->request->getPost('id_kelas'),
                'jam_ke' => $this->request->getPost('jam_ke'),
                'hari' => $this->request->getPost('hari'),
                'id_guru' => $this->request->getPost('id_guru'),
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
            'id_kelas' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jam_ke' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'hari' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'id_guru' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'id_kelas' => $json->id_kelas,
                'jam_ke' => $json->jam_ke,
                'hari' => $json->hari,
                'id_guru' => $json->id_guru,
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
}
