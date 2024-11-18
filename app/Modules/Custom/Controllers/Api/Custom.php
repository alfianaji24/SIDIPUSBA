<?php

namespace App\Modules\Custom\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Custom\Models\CustomModel;
use Pusher\Pusher;

class Custom extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = CustomModel::class;
    protected $pusher;

    public function __construct()
    {
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
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->where('status', 1)->findAll()], 200);
    }

    public function create()
    {
        $rules = [
            'tipe' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'bgcolor' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'title' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'konten' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'tipe' => $json->tipe,
                'bgcolor' => $json->bgcolor,
                'title' => $json->title,
                'konten' => $json->konten,
                'status' => $json->status,
            ];
        } else {
            $data = [
                'tipe' => $this->request->getPost('tipe'),
                'bgcolor' => $this->request->getPost('bgcolor'),
                'title' => $this->request->getPost('title'),
                'konten' => $this->request->getPost('konten'),
                'status' => $this->request->getPost('status'),
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

            // Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'custom';
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
            'tipe' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'bgcolor' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'title' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'konten' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'tipe' => $json->tipe,
                'bgcolor' => $json->bgcolor,
                'title' => $json->title,
                'konten' => $json->konten,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'tipe' => $input->tipe,
                'bgcolor' => $input->bgcolor,
                'title' => $input->title,
                'konten' => $input->konten,
            ];
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
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'custom';
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

            // Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'custom';
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

    public function setAktif($id = NULL)
    {
        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $status = $json->status;
            $data = [
                'status' => $status,
            ];
        } else {
            $input = $this->request->getRawInput();
            $status = $input['status'];
            $data = [
                'status' => $status,
            ];
        }

        if ($data > 0) {
            $this->model->update($id, $data);

            // Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'custom';
                    $this->pusher->trigger('my-channel', 'my-event', $push);
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
