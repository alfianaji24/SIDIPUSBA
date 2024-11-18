<?php

namespace App\Modules\Galeri\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Galeri\Models\GaleriModel;
use Pusher\Pusher;

class Galeri extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = GaleriModel::class;
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
            'label' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'deskripsi' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'image_url' => [
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
                'label' => $json->label,
                'deskripsi' => $json->deskripsi,
                'image_url' => $json->image_url,
                'status' => $json->status,
            ];
        } else {
            $data = [
                'label' => $this->request->getPost('label'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'image_url' => $this->request->getPost('image_url'),
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

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'galeri';
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
            'label' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'deskripsi' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $image = $json->image_url;
            if ($image != '') {
                $data = [
                    'label' => $json->label,
                    'deskripsi' => $json->deskripsi,
                    'image_url' => $image,
                ];
            } else {
                $data = [
                    'label' => $json->label,
                    'deskripsi' => $json->deskripsi,
                ];
            }
        } else {
            $input = $this->request->getRawInput();
            $image = $input->image_url;
            if ($image != '') {
                $data = [
                    'label' => $input->label,
                    'deskripsi' => $input->deskripsi,
                    'image_url' => $image,
                ];
            } else {
                $data = [
                    'label' => $input->label,
                    'deskripsi' => $input->deskripsi,
                ];
            }
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
                    $push['event'] = 'galeri';
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
        $image = $hapus['image_url'];
        if ($hapus) {
            if (file_exists($image)) :
                unlink($image);
            endif;
            $this->model->delete($id);

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'galeri';
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
            'image' => [
                'rules'  => 'uploaded[image]|max_size[image,51200]|is_image[image]',
                'errors' => []
            ],
        ];

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
                return $this->respond(["status" => true, "message" => lang('App.imgSuccess'), "data" => ["url" => $path . $fileName]], 200);
            } else {
                return $this->respond(["status" => false, "message" => lang('App.imgFailed'), "data" => []], 200);
            }
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

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'galeri';
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
