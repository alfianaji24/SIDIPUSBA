<?php

namespace App\Modules\Sekolah\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Sekolah\Models\HaribelajarModel;
use App\Libraries\Settings;

class Haribelajar extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = HaribelajarModel::class;
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
        helper('disfo');
        $input = $this->request->getVar();
        $id_jam_pelajaran =  $input['id'];
        $kegiatan = $this->model->where('id_jampelajaran', $id_jam_pelajaran)->get()->getRow();
        if (isset($kegiatan)) {
            $hari = hari(date("D"));
            switch ($hari) {
                case 'Senin':
                    $hasil['ket'] = kegiatan($kegiatan->senin)['id'];
                    $hasil['des'] = kegiatan($kegiatan->senin)['ket'];
                    break;
                case 'Selasa':
                    $hasil['ket'] = kegiatan($kegiatan->selasa)['id'];
                    $hasil['des'] = kegiatan($kegiatan->selasa)['ket'];
                    break;
                case 'Rabu':
                    $hasil['ket'] = kegiatan($kegiatan->rabu)['id'];
                    $hasil['des'] = kegiatan($kegiatan->rabu)['ket'];
                    break;
                case 'Kamis':
                    $hasil['ket'] = kegiatan($kegiatan->kamis)['id'];
                    $hasil['des'] = kegiatan($kegiatan->kamis)['ket'];
                    break;
                case 'Jumat':
                    $hasil['ket'] = kegiatan($kegiatan->jumat)['id'];
                    $hasil['des'] = kegiatan($kegiatan->jumat)['ket'];
                    break;
                case 'Sabtu':
                    $hasil['ket'] = kegiatan($kegiatan->sabtu)['id'];
                    $hasil['des'] = kegiatan($kegiatan->sabtu)['ket'];
                    break;
                default:
                    $hasil['ket'] = "Jam Belajar Tidak Aktif";
                    $hasil['des'] = "";
            }
        } else {
            $hasil['ket'] = "Jam Belajar Tidak Aktif";
            $hasil['des'] = "";
        }

        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $hasil], 200);
    }

    public function create()
    {
        $rules = [
            'id_jampelajaran' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'senin' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'selasa' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'rabu' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'kamis' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jumat' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'sabtu' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'id_jampelajaran' => $json->id_jampelajaran,
                'senin' => $json->senin,
                'selasa' => $json->selasa,
                'rabu' => $json->rabu,
                'kamis' => $json->kamis,
                'jumat' => $json->jumat,
                'sabtu' => $json->sabtu,
            ];
        } else {
            $data = [
                'id_jampelajaran' => $this->request->getPost('id_jampelajaran'),
                'senin' => $this->request->getPost('senin'),
                'selasa' => $this->request->getPost('selasa'),
                'rabu' => $this->request->getPost('rabu'),
                'kamis' => $this->request->getPost('kamis'),
                'jumat' => $this->request->getPost('jumat'),
                'sabtu' => $this->request->getPost('sabtu'),
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
            'id_jampelajaran' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'senin' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'selasa' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'rabu' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'kamis' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jumat' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'sabtu' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'id_jampelajaran' => $json->id_jampelajaran,
                'senin' => $json->senin,
                'selasa' => $json->selasa,
                'rabu' => $json->rabu,
                'kamis' => $json->kamis,
                'jumat' => $json->jumat,
                'sabtu' => $json->sabtu,
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

    public function belajar()
    {
        $input = $this->request->getVar();
        $hari = $input['hari'];
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->getHariJamBelajar($hari)], 200);
    }
}
