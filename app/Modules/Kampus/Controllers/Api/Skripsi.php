<?php

namespace App\Modules\Kampus\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Kampus\Models\SkripsiModel;
use App\Libraries\Settings;
use Pusher\Pusher;

class Skripsi extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = SkripsiModel::class;
    protected $setting;
    protected $pusher;
    
    public function __construct()
    {
        //memanggil Model
        $this->setting = new Settings();

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
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->where('DATE(tanggal_skripsi) >=', date('Y-m-d'))->findAll()], 200);
    }

    public function create()
    {
        $rules = [
            'npm' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nama_mhs' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tanggal_skripsi' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'judul_skripsi' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'waktu' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'ruang' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'npm' => $json->npm,
                'nama_mhs' => $json->nama_mhs,
                'tanggal_skripsi' => $json->tanggal_skripsi,
                'judul_skripsi' => $json->judul_skripsi,
                'waktu' => $json->waktu,
                'ruang' => $json->ruang,
            ];
        } else {
            $data = [
                'npm' => $this->request->getPost('npm'),
                'nama_mhs' => $this->request->getPost('nama_mhs'),
                'tanggal_skripsi' => $this->request->getPost('tanggal_skripsi'),
                'judul_skripsi' => $this->request->getPost('judul_skripsi'),
                'waktu' => $this->request->getPost('waktu'),
                'ruang' => $this->request->getPost('ruang'),
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

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'skripsi';
                    $this->pusher->trigger('my-channel', 'my-event', $push);
                }
            }

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
            'npm' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nama_mhs' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tanggal_skripsi' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'judul_skripsi' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'waktu' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'ruang' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'npm' => $json->npm,
                'nama_mhs' => $json->nama_mhs,
                'tanggal_skripsi' => $json->tanggal_skripsi,
                'judul_skripsi' => $json->judul_skripsi,
                'waktu' => $json->waktu,
                'ruang' => $json->ruang,
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

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'skripsi';
                    $this->pusher->trigger('my-channel', 'my-event', $push);
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

    public function delete($id = null)
    {
        $hapus = $this->model->find($id);
        if ($hapus) {
            $this->model->delete($id);

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'skripsi';
                    $this->pusher->trigger('my-channel', 'my-event', $push);
                }
            }

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
