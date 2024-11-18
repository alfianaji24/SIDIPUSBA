<?php

namespace App\Modules\Video\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Video\Models\VideoModel;
use App\Libraries\Settings;
use Pusher\Pusher;

class Video extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = VideoModel::class;
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
        if ($this->setting->info['video_youtube'] == 'no') {
            $data = $this->model->where(['source' => 1, 'status' => 1])->orderBy('upload_time', 'DESC')->findAll();
            $result = array();
            foreach ($data as $video) {
                $alamat = base_url() . '/' . $video['video_url'];
                array_push($result, array($alamat));
            }
        } else {
            $result = [];
        }

        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $result], 200);
    }

    public function create()
    {
        $rules = [
            'judul' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'source' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'judul' => $json->judul,
                'source' => $json->source,
                'video_url' => $json->video_url,
                'kode_youtube' => $json->kode_youtube,
                'upload_time' => date('Y-m-d H:i:s'),
                'status' => $json->status,
            ];
        } else {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'source' => $this->request->getPost('source'),
                'video_url' => $this->request->getPost('video_url'),
                'kode_youtube' => $this->request->getPost('kode_youtube'),
                'upload_time' => date('Y-m-d H:i:s'),
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
                    $push['event'] = 'video';
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
            'judul' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'judul' => $json->judul,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'judul' => $input->judul,
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

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'video';
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
        $source = $hapus['source'];
        $video = $hapus['video_url'];
        if ($hapus) {
            if ($source == '1' && $video != '') :
                if (file_exists($video)) :
                    unlink($video);
                endif;
            endif;
            $this->model->delete($id);

            //Pusher
            if (@fsockopen('www.google.com', 80)) {
                if ((getenv('PUSHER_APP_KEY') != "") && (getenv('PUSHER_APP_SECRET') != "") && (getenv('PUSHER_APP_ID') != "")) {
                    $push['message'] = lang('App.refreshSuccess');
                    $push['event'] = 'video';
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
        //Maksimal ukuran 204800 KB = 200 MB
        $rules = [
            'video' => [
                'rules'  => 'uploaded[video]|ext_in[video,mp4]|max_size[video,204800]',
                'errors' => []
            ],
        ];

        $video = $this->request->getFile('video');
        $fileName = $video->getRandomName();
        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.videoFailed'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $path = "videos/";
            $moved = $video->move($path, $fileName);
            if ($moved) {
                return $this->respond(["status" => true, "message" => lang('App.videoSuccess'), "data" => ["url" => $path . $fileName]], 200);
            } else {
                return $this->respond(["status" => false, "message" => lang('App.videoFailed'), "data" => []], 200);
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
                    $push['event'] = 'video';
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

    public function plupload()
    {
        // (A) HELPER FUNCTION - SERVER RESPONSE
        function verbose($ok = 1, $info = "")
        {
            if ($ok == 0) {
                http_response_code(400);
            }
            exit(json_encode(["ok" => $ok, "info" => $info]));
        }

        // (B) INVALID UPLOAD
        if (empty($_FILES) || $_FILES["file"]["error"]) {
            //verbose(0, "Failed to move uploaded file.");
            return $this->respond(["status" => false, "message" => "Failed to move uploaded file.", "data" => []], 200);
        }

        // (C) UPLOAD DESTINATION - CHANGE FOLDER IF REQUIRED!
        $path = "videos/";
        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true)) {
                //verbose(0, "Failed to create $path");
                return $this->respond(["status" => false, "message" => "Failed to create $path", "data" => []], 200);
            }
        }
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
        $newName = preg_replace('/\s+/', '_', $fileName);
        $filePath = $path . DIRECTORY_SEPARATOR . $newName;

        // (D) DEAL WITH CHUNKS
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
        if ($out) {
            $in = @fopen($_FILES["file"]["tmp_name"], "rb");
            if ($in) {
                while ($buff = fread($in, 4096)) {
                    fwrite($out, $buff);
                }
            } else {
                //verbose(0, "Failed to open input stream");
                return $this->respond(["status" => false, "message" => "Failed to open output stream", "data" => []], 200);
            }
            @fclose($in);
            @fclose($out);
            @unlink($_FILES["file"]["tmp_name"]);
        } else {
            //verbose(0, "Failed to open output stream");
            return $this->respond(["status" => false, "message" => "Failed to open output stream", "data" => []], 200);
        }

        // (E) CHECK IF FILE HAS BEEN UPLOADED
        if (!$chunks || $chunk == $chunks - 1) {
            rename("{$filePath}.part", $filePath);
        }
        //verbose(1, "Upload OK");
        return $this->respond(["status" => true, "message" => lang('App.videoSuccess'), "data" => ["url" => $path . $newName]], 200);
    }

    public function delete_uploaded()
    {
        $input = $this->request->getVar();
        $query = $input['video_url'];
        if ($query) {
            if (file_exists($query)) :
                unlink($query);
            endif;
            $response = [
                'status' => true,
                'message' => lang('App.videoDeleted'),
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
