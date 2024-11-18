<?php

namespace App\Modules\Agenda\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Agenda\Models\AgendaModel;
use App\Libraries\Settings;
use Pusher\Pusher;

class Agenda extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = AgendaModel::class;
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
        $bulan = date("n");
        $limit = $this->setting->info['limit_agenda'];
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->where('MONTH(tgl_agenda)', $bulan)->orderBy('tgl_agenda', 'DESC')->findAll($limit)], 200);
    }

    public function create()
    {
        $rules = [
            'nama_agenda' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tempat_agenda' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tgl_agenda' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'waktu' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'nama_agenda' => $json->nama_agenda,
                'tempat_agenda' => $json->tempat_agenda,
                'tgl_agenda' => $json->tgl_agenda,
                'waktu' => $json->waktu,
                'jenis_agenda' => 1,
            ];
        } else {
            $data = [
                'nama_agenda' => $this->request->getPost('nama_agenda'),
                'tempat_agenda' => $this->request->getPost('tempat_agenda'),
                'tgl_agenda' => $this->request->getPost('tgl_agenda'),
                'waktu' => $this->request->getPost('waktu'),
                'jenis_agenda' => 1,
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
                    $push['event'] = 'agenda';
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
            'nama_agenda' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tempat_agenda' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'tgl_agenda' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'waktu' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'nama_agenda' => $json->nama_agenda,
                'tempat_agenda' => $json->tempat_agenda,
                'tgl_agenda' => $json->tgl_agenda,
                'waktu' => $json->waktu,
                'jenis_agenda' => 1,
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
                    $push['event'] = 'agenda';
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
                    $push['event'] = 'agenda';
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
