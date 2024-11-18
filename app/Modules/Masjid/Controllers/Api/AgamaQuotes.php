<?php

namespace App\Modules\Masjid\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Masjid\Models\AgamaquotesModel;
use App\Libraries\Settings;
use Pusher\Pusher;

class AgamaQuotes extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = AgamaquotesModel::class;
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
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->orderBy('id', 'DESC')->findAll()], 200);
    }

    public function create()
    {
        $rules = [
            'isi_quotes' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'suratriwayat' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'isi_quotes' => $json->isi_quotes,
                'suratriwayat' => $json->suratriwayat,
            ];
        } else {
            $data = [
                'isi_quotes' => $this->request->getPost('isi_quotes'),
                'suratriwayat' => $this->request->getPost('suratriwayat'),
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
                    $push['event'] = 'quotes';
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
            'isi_quotes' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'suratriwayat' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'isi_quotes' => $json->isi_quotes,
                'suratriwayat' => $json->suratriwayat,
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
                    $push['event'] = 'quotes';
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
                    $push['event'] = 'quotes';
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
