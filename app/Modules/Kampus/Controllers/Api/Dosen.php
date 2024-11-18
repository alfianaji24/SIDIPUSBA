<?php

namespace App\Modules\Kampus\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Kampus\Models\DosenModel;
use App\Libraries\Settings;
use Pusher\Pusher;

class Dosen extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = DosenModel::class;
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
        $limit = $this->setting->info['limit_dosen'];
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->orderBy('id', 'RANDOM')->findAll($limit)], 200);
    }

    public function create()
    {
        $rules = [
            'nip_nik' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nama_lengkap' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tempat_lahir' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tanggal_lahir' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jabatan' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'nip_nik' => $json->nip_nik,
                'nama_lengkap' => $json->nama_lengkap,
                'tempat_lahir' => $json->tempat_lahir,
                'tanggal_lahir' => $json->tanggal_lahir,
                'foto' => $json->foto,
                'jabatan' => $json->jabatan,
            ];
        } else {
            $data = [
                'nip_nik' => $this->request->getPost('nip_nik'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'foto' => $this->request->getPost('foto'),
                'jabatan' => $this->request->getPost('jabatan'),
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
                    $push['event'] = 'dosen';
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
            'nip_nik' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nama_lengkap' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tempat_lahir' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tanggal_lahir' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jabatan' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'nip_nik' => $json->nip_nik,
                'nama_lengkap' => $json->nama_lengkap,
                'tempat_lahir' => $json->tempat_lahir,
                'tanggal_lahir' => $json->tanggal_lahir,
                'foto' => $json->foto,
                'jabatan' => $json->jabatan,
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
                    $push['event'] = 'dosen';
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
        $image = $hapus['foto'];
        if ($hapus) {
            if ($image != 'images/photo.png'):
                unlink($image);
            endif;
            $this->model->delete($id);

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'dosen';
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

    public function upload()
    {
        //Maksimal ukuran 51200 KB = 50 MB
        $rules = [
            'foto' => [
                'rules'  => 'uploaded[foto]|max_size[foto,51200]|is_image[foto]',
                'errors' => []
            ],
        ];

        $image = $this->request->getFile('foto');
        $fileName = $image->getRandomName();
        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.imgFailed'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $path = "images/dosen/";
            $moved = $image->move($path, $fileName);
            if ($moved) {
                return $this->respond(["status" => true, "message" => lang('App.imgSuccess'), "data" => ["url" => $path . $fileName]], 200);
            } else {
                return $this->respond(["status" => false, "message" => lang('App.imgFailed'), "data" => []], 200);
            }
        } 
    }
}
