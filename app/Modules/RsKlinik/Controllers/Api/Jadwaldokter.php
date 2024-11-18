<?php

namespace App\Modules\RsKlinik\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\RsKlinik\Models\JadwaldokterModel;
use App\Libraries\Settings;

class Jadwaldokter extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = JadwaldokterModel::class;
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
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->getJadwaldokter($hari)], 200);
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->find($id)], 200);
    }

    public function display()
    {
        $senin = $this->model->getJadwaldokterHari('senin');
        $selasa = $this->model->getJadwaldokterHari('selasa');
        $rabu = $this->model->getJadwaldokterHari('rabu');
        $kamis = $this->model->getJadwaldokterHari('kamis');
        $jumat = $this->model->getJadwaldokterHari('jumat');
        $sabtu = $this->model->getJadwaldokterHari('sabtu');

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

    public function display2()
    {
        $input = $this->request->getVar();
        $hari = $input['hari'];
        $query = $this->model->dokterPraktek($hari);
        if (!empty($query)) {
            $data = $query;
        } else {
            $data = ['error' => "Tidak ada jadwal dokter pada jam ini."];
        }
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $data], 200);
    }

    public function create()
    {
        $rules = [
            'id_ruang' => [
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
            'id_dokter' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'id_ruang' => $json->id_ruang,
                'jam_ke' => $json->jam_ke,
                'hari' => $json->hari,
                'id_dokter' => $json->id_dokter,
            ];
        } else {
            $data = [
                'id_ruang' => $this->request->getPost('id_ruang'),
                'jam_ke' => $this->request->getPost('jam_ke'),
                'hari' => $this->request->getPost('hari'),
                'id_dokter' => $this->request->getPost('id_dokter'),
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
            'id_ruang' => [
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
            'id_dokter' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'id_ruang' => $json->id_ruang,
                'jam_ke' => $json->jam_ke,
                'hari' => $json->hari,
                'id_dokter' => $json->id_dokter,
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
