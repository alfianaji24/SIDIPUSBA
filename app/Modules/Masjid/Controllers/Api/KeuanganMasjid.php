<?php

namespace App\Modules\Masjid\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Masjid\Models\KeuanganmasjidModel;
use App\Libraries\Settings;
use Pusher\Pusher;

class KeuanganMasjid extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = KeuanganmasjidModel::class;
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
        $data['pemasukan'] = $this->model->nominal_pemasukan();
        $data['pengeluaran'] = $this->model->nominal_pengeluaran();
        $data['keuangan'] = $this->model->get_transaksi();
        foreach ($data as $key => $value) {
            $arrayData = [
                'pemasukan' => $data['pemasukan'],
                'pengeluaran' => $data['pengeluaran'],
                'keuangan' => $data['keuangan'],
            ];
        }

        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $arrayData], 200);
    }

    public function create()
    {
        $rules = [
            'tanggal' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'uraian' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jenis' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $jenis =  $json->jenis;
            $nominal = $json->nominal;
            $pemasukan = 0;
            $pengeluaran = 0;

            if ($jenis == 1) {
                $pemasukan = $nominal;
            }
            if ($jenis == 2) {
                $pengeluaran = $nominal;
            }

            $data = [
                'tanggal' => $json->tanggal,
                'uraian' => $json->uraian,
                'jenis' => $jenis,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
            ];
        } else {
            $jenis = $this->request->getPost('jenis');
            $nominal = $this->request->getPost('nominal');
            $pemasukan = 0;
            $pengeluaran = 0;

            if ($jenis == 1) {
                $pemasukan = $nominal;
            }
            if ($jenis == 2) {
                $pengeluaran = $nominal;
            }

            $data = [
                'tanggal' => $this->request->getPost('tanggal'),
                'uraian' => $this->request->getPost('uraian'),
                'jenis' => $jenis,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
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
                    $push['event'] = 'keuangan';
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
            'tanggal' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'uraian' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'jenis' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $jenis =  $json->jenis;
            $nominal = $json->nominal;
            $pemasukan = 0;
            $pengeluaran = 0;

            if ($jenis == 1) {
                $pemasukan = $nominal;
            }
            if ($jenis == 2) {
                $pengeluaran = $nominal;
            }

            $data = [
                'tanggal' => $json->tanggal,
                'uraian' => $json->uraian,
                'jenis' => $jenis,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
            ];
        } else {
            $input = $this->request->getRawInput();
            $jenis =  $input->jenis;
            $nominal = $input->nominal;
            $pemasukan = 0;
            $pengeluaran = 0;

            if ($jenis == 1) {
                $pemasukan = $nominal;
            }
            if ($jenis == 2) {
                $pengeluaran = $nominal;
            }

            $data = [
                'tanggal' => $input->tanggal,
                'uraian' => $input->uraian,
                'jenis' => $jenis,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
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
                    $push['event'] = 'keuangan';
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
                    $push['event'] = 'keuangan';
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

    public function saldo()
    {
        $keuangan = $this->model->findAll();
        if ($keuangan > 0) {
            $no = 0;
            $jml_pemasukan = 0;
            $jml_pengeluaran = 0;
            foreach ($keuangan as $row) {
                $no++;
                $jml_pemasukan = $jml_pemasukan + $row['pemasukan'];
                $jml_pengeluaran = $jml_pengeluaran + $row['pengeluaran'];
            }
            $saldo = $jml_pemasukan - $jml_pengeluaran;
        }

        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $saldo], 200);
    }
}
