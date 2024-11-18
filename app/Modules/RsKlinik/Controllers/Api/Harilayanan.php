<?php

namespace App\Modules\RsKlinik\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\RsKlinik\Models\HarilayananModel;
use App\Libraries\Settings;

class Harilayanan extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = HarilayananModel::class;
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
        $layanan = $this->model->where('id_jampelayanan', $id_jam_pelajaran)->get()->getRow();
        if (isset($layanan)) {
            $hari = hari(date("D"));
            switch ($hari) {
                case 'Senin':
                    $hasil['ket'] = layanan($layanan->senin)['id'];
                    $hasil['des'] = layanan($layanan->senin)['ket'];
                    break;
                case 'Selasa':
                    $hasil['ket'] = layanan($layanan->selasa)['id'];
                    $hasil['des'] = layanan($layanan->selasa)['ket'];
                    break;
                case 'Rabu':
                    $hasil['ket'] = layanan($layanan->rabu)['id'];
                    $hasil['des'] = layanan($layanan->rabu)['ket'];
                    break;
                case 'Kamis':
                    $hasil['ket'] = layanan($layanan->kamis)['id'];
                    $hasil['des'] = layanan($layanan->kamis)['ket'];
                    break;
                case 'Jumat':
                    $hasil['ket'] = layanan($layanan->jumat)['id'];
                    $hasil['des'] = layanan($layanan->jumat)['ket'];
                    break;
                case 'Sabtu':
                    $hasil['ket'] = layanan($layanan->sabtu)['id'];
                    $hasil['des'] = layanan($layanan->sabtu)['ket'];
                    break;
                default:
                    $hasil['ket'] = "Jam Layanan Tidak Aktif";
                    $hasil['des'] = "";
            }
        } else {
            $hasil['ket'] = "Jam Layanan Tidak Aktif";
            $hasil['des'] = "";
        }

        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $hasil], 200);
    }

    public function create()
    {
        $rules = [
            'id_jampelayanan' => [
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
                'id_jampelayanan' => $json->id_jampelayanan,
                'senin' => $json->senin,
                'selasa' => $json->selasa,
                'rabu' => $json->rabu,
                'kamis' => $json->kamis,
                'jumat' => $json->jumat,
                'sabtu' => $json->sabtu,
            ];
        } else {
            $data = [
                'id_jampelayanan' => $this->request->getPost('id_jampelayanan'),
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
            'id_jampelayanan' => [
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
                'id_jampelayanan' => $json->id_jampelayanan,
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

    public function layanan()
    {
        $input = $this->request->getVar();
        $hari = $input['hari'];
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->getHariJamLayanan($hari)], 200);
    }
}
