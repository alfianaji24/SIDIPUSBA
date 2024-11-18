<?php

namespace App\Modules\News\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\News\Models\NewsModel;
use App\Libraries\Settings;
use Pusher\Pusher;

class News extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = NewsModel::class;
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

    public function news()
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->where('jenis_news', '1')->orderBy('id', 'DESC')->findAll()], 200);
    }

    public function info()
    {
        $limit = $this->setting->info['limit_info'];
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->where('jenis_news', '2')->orderBy('id', 'DESC')->findAll($limit)], 200);
    }

    public function masjid()
    {
        $limit = $this->setting->info['limit_info'];
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->where('jenis_news', '3')->orderBy('id', 'DESC')->findAll($limit)], 200);
    }

    public function create()
    {
        $rules = [
            'tgl_news' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jenis_news' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'text_news' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'tgl_news' => $json->tgl_news,
                'text_news' => $json->text_news,
                'jenis_news' => $json->jenis_news,
            ];
        } else {
            $data = [
                'tgl_news' => $this->request->getPost('tgl_news'),
                'text_news' => $this->request->getPost('text_news'),
                'jenis_news' => $this->request->getPost('jenis_news'),
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
                    $push['event'] = 'news';
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
            'tgl_news' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jenis_news' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'text_news' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'tgl_news' => $json->tgl_news,
                'text_news' => $json->text_news,
                'jenis_news' => $json->jenis_news,
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
                    $push['event'] = 'news';
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
                    $push['event'] = 'news';
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
