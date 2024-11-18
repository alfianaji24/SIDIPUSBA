<?php

namespace App\Modules\Masjid\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Masjid\Models\JadwalsholatModel;
use App\Libraries\Settings;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class JadwalSholat extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = JadwalsholatModel::class;
    protected $setting;

    public function __construct()
    {
        //memanggil Model
        $this->setting = new Settings();
    }

    public function index()
    {
        $input = $this->request->getVar();
        $idbulan = $input['idbulan'];
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        $data = $this->model->getJadwalsholat($idbulan, $start, $end);
        if (!empty($data)) {
            $response = [
                "status" => true,
                "message" => lang('App.getSuccess'),
                "data" => $data
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.noData'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->find($id)], 200);
    }

    public function import()
    {
        $file_excel = $this->request->getFile('fileexcel');
        $id_bulan = $this->request->getPost('idbulan');
        $ext = $file_excel->getClientExtension();
        if ($ext == 'xls') {
            $render = new Xls();
        } else {
            $render = new Xlsx();
        }
        $spreadsheet = $render->load($file_excel);

        $allDataInSheet = $spreadsheet->getActiveSheet()->toArray();

        // array Count
        $arrayCount = count($allDataInSheet);
        $flag = 0;
        $createArray = array('NO', 'IMSAK', 'SUBUH', 'TERBIT', 'DUHA', 'DZUHUR', 'ASHAR', 'MAGRIB', 'ISYA');
        $makeArray = array('NO' => 'NO', 'IMSAK' => 'IMSAK', 'SUBUH' => 'SUBUH', 'TERBIT' => 'TERBIT', 'DUHA' => 'DUHA', 'DZUHUR' => 'DZUHUR', 'ASHAR' => 'ASHAR', 'MAGRIB' => 'MAGRIB', 'ISYA' => 'ISYA');
        $SheetDataKey = array();
        foreach ($allDataInSheet as $dataInSheet) {
            foreach ($dataInSheet as $key => $value) {
                if (in_array(trim($value), $createArray)) {
                    $value = preg_replace('/\s+/', '', $value);
                    $SheetDataKey[trim($value)] = $key;
                }
            }
        }

        $dataDiff = array_diff_key($makeArray, $SheetDataKey);
        if (empty($dataDiff)) {
            $flag = 1;
        }

        if ($flag == 1) {
            $tgl = 0;
            for ($i = 1; $i <= $arrayCount; $i++) {
                $tgl++;
                $tanggal = date("Y") . "-" . $id_bulan . "-" . $tgl;
                $no = $SheetDataKey['NO'];
                $imsak = $SheetDataKey['IMSAK'];
                $subuh = $SheetDataKey['SUBUH'];
                $terbit = $SheetDataKey['TERBIT'];
                $duha = $SheetDataKey['DUHA'];
                $dzuhur = $SheetDataKey['DZUHUR'];
                $ashar = $SheetDataKey['ASHAR'];
                $magrib = $SheetDataKey['MAGRIB'];
                $isya = $SheetDataKey['ISYA'];

                $no = filter_var(trim($allDataInSheet[$i][$no]), FILTER_SANITIZE_STRING);
                $imsak = filter_var(trim($allDataInSheet[$i][$imsak]), FILTER_SANITIZE_STRING);
                $subuh = filter_var(trim($allDataInSheet[$i][$subuh]), FILTER_SANITIZE_STRING);
                $terbit = filter_var(trim($allDataInSheet[$i][$terbit]), FILTER_SANITIZE_STRING);
                $duha = filter_var(trim($allDataInSheet[$i][$duha]), FILTER_SANITIZE_STRING);
                $dzuhur = filter_var(trim($allDataInSheet[$i][$dzuhur]), FILTER_SANITIZE_STRING);
                $ashar = filter_var(trim($allDataInSheet[$i][$ashar]), FILTER_SANITIZE_STRING);
                $magrib = filter_var(trim($allDataInSheet[$i][$magrib]), FILTER_SANITIZE_STRING);
                $isya = filter_var(trim($allDataInSheet[$i][$isya]), FILTER_SANITIZE_STRING);

                $data = [
                    'id_bulan' => $id_bulan,
                    'date' => $tanggal,
                    'imsak' => $imsak,
                    'subuh' => $subuh,
                    'terbit' => $terbit,
                    'dhuha' => $duha,
                    'dzuhur' => $dzuhur,
                    'ashar' => $ashar,
                    'maghrib' => $magrib,
                    'isya' => $isya
                ];
                $this->model->save($data);
            }

            //Query find date with 0000-00-00
            $query = $this->model->where('date', '0000-00-00')->findAll();
            foreach ($query as $row) {
                //Delete
                $this->model->delete($row['id']);
            }

            return $this->respond(["status" => true, "message" => lang('App.saveSuccess'), "data" => []], 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.saveFailed'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    /* function _isCurl()
    {
        return function_exists('curl_version');
    }

    function fOpenRequest($url)
    {
        $file = fopen($url, 'r');
        $data = stream_get_contents($file);
        fclose($file);
        return $data;
    }

    function curlRequest($url)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($c);
        curl_close($c);
        return $data;
    } */

    public function display()
    {
        $modejadwal = $this->setting->info['jadwal_sholat'];
        if ($modejadwal == 'excel') {
            return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->where(['id_bulan' => date('m'), 'date' => date('Y-m-d')])->first()], 200);
        } else {
            //get JSON
            $city = $this->setting->info['kota'];
            $tahun = date('Y');
            $bulan = date('m');
            $tanggal = date('d');
            $data = $this->model->getApijadwalsholat($city, $tahun, $bulan, $tanggal);

            //return data array()
            return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $data], 200);
        }
    }

    public function cek_waktu_solat()
    {
        $waktu_solat = "";
        $modejadwal = $this->setting->info['jadwal_sholat'];
        if ($modejadwal == 'excel') {
            $jadwal_solat = $this->model->where(['id_bulan' => date('m'), 'date' => date('Y-m-d')])->first();
        } else {
            //get JSON
            $city = $this->setting->info['kota'];
            $tahun = date('Y');
            $bulan = date('m');
            $tanggal = date('d');
            $jadwal_solat = $this->model->getApijadwalsholat($city, $tahun, $bulan, $tanggal);
        }

        if (!empty($jadwal_solat)) {
            $tanggal = $jadwal_solat['date'];
            $besok = date("Y-m-d", strtotime($tanggal . ' +1 day'));
            $subuh = strtotime($jadwal_solat['subuh']);
            $dhuha = strtotime($jadwal_solat['dhuha']);
            $dzuhur = strtotime($jadwal_solat['dzuhur']);
            $ashar = strtotime($jadwal_solat['ashar']);
            $magrib = strtotime($jadwal_solat['maghrib']);
            $isya = strtotime($jadwal_solat['isya']);
            if (time() >= $subuh && time() <= $dzuhur) {
                $waktu_solat = "Dzuhur";
                $date = date_create($tanggal . " " . $jadwal_solat['dzuhur']);
                $waktu = date_format($date, "Y-m-d H:i:s");
                $date2 = date_create($tanggal . " " . $jadwal_solat['subuh']);
                $waktu2 = date_format($date2, "Y-m-d H:i:s");
                $iqomah = date("Y-m-d H:i:s", strtotime($waktu2 . " +10 minutes"));
            }
            if (time() >= $dzuhur && time() <= $ashar) {
                $waktu_solat = "Ashar";
                $date = date_create($tanggal . " " . $jadwal_solat['ashar']);
                $waktu = date_format($date, "Y-m-d H:i:s");
                $date2 = date_create($tanggal . " " . $jadwal_solat['dzuhur']);
                $waktu2 = date_format($date2, "Y-m-d H:i:s");
                $iqomah = date("Y-m-d H:i:s", strtotime($waktu2 . " +10 minutes"));
            }
            if (time() >= $ashar && time() <= $magrib) {
                $waktu_solat = "Maghrib";
                $date = date_create($tanggal . " " . $jadwal_solat['maghrib']);
                $waktu = date_format($date, "Y-m-d H:i:s");
                $date2 = date_create($tanggal . " " . $jadwal_solat['ashar']);
                $waktu2 = date_format($date2, "Y-m-d H:i:s");
                $iqomah = date("Y-m-d H:i:s", strtotime($waktu2 . " +10 minutes"));
            }
            if (time() >= $magrib && time() <= $isya) {
                $waktu_solat = "Isya";
                $date = date_create($tanggal . " " . $jadwal_solat['isya']);
                $waktu = date_format($date, "Y-m-d H:i:s");
                $date2 = date_create($tanggal . " " . $jadwal_solat['maghrib']);
                $waktu2 = date_format($date2, "Y-m-d H:i:s");
                $iqomah = date("Y-m-d H:i:s", strtotime($waktu2 . " +10 minutes"));
            }
            if (time() > $isya) {
                $waktu_solat = "Subuh";
                $date = date_create($besok . " " . $jadwal_solat['subuh']);
                $waktu = date_format($date, "Y-m-d H:i:s");
                $date2 = date_create($tanggal . " " . $jadwal_solat['isya']);
                $waktu2 = date_format($date2, "Y-m-d H:i:s");
                $iqomah = date("Y-m-d H:i:s", strtotime($waktu2 . " +10 minutes"));
            }
            $hasil = array('jelang' => $waktu_solat, 'waktu' => $waktu, 'last' => $waktu2, 'iqomah' => $iqomah, 'time' => time());
        } else {
            $hasil = [];
        }

        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $hasil], 200);
    }

    public function deleteMultiple()
    {
        $input = $this->request->getVar('data');
        $data = json_decode($input, true);
        $coundData = count($data);
        $count = 0;

        foreach ($data as $data) {
            $id = $data['id'];
            $this->model->delete($id);
            $count = $this->model->affectedRows();
        }

        $response = [
            'status' => true,
            'message' => lang('App.delSuccess'),
            'data' => [],
        ];
        return $this->respond($response, 200);
    }
}
