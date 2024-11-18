<?php

namespace App\Modules\Cuaca\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Setting\Models\KotaModel;
use App\Modules\Setting\Models\ProvinsiModel;
use App\Libraries\Settings;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Pusher\Pusher;

class Cuaca extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = KotaModel::class;
    protected $setting;
    protected $provinsi;
    protected $pusher;

    public function __construct()
    {
        //memanggil Model
        $this->setting = new Settings();
        $this->provinsi = new ProvinsiModel();

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

    function _isCurl()
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
    }


    public function index()
    {
        $api_key = env('OPENWEATHER_API_KEY');

        //get City
        $city = $this->setting->info['kota'];
        $cari = $this->model->find($city);
        $data1 = $cari['lokasi'];
        $pecah = explode(" ", $data1);
        $kota = ucfirst($pecah[1]);

        //get Provinsi
        $province = $this->setting->info['provinsi'];
        $cari = $this->provinsi->find($province);
        $data2 = $cari['provinsi'];
        $provinsi = $data2;

        if (@fsockopen('www.google.com', 80)) {
            if ($this->_isCurl()) {
                $json1 = $this->curlRequest("http://api.openweathermap.org/data/2.5/weather?appid=$api_key&units=metric&q=$kota", false);
            } else {
                $json1 = $this->fOpenRequest("http://api.openweathermap.org/data/2.5/weather?appid=$api_key&units=metric&q=$kota", false);
            }
        
            if ($this->_isCurl()) {
                $json2 = $this->curlRequest("http://api.openweathermap.org/data/2.5/weather?appid=$api_key&units=metric&q=$provinsi", false);
            } else {
                $json2 = $this->fOpenRequest("http://api.openweathermap.org/data/2.5/weather?appid=$api_key&units=metric&q=$provinsi", false);
            }
        } else {
            $json1 = "";
            $json2 = "";
        }

        //decode JSON to array
        $result1 = json_decode($json1, true);
        $result2 = json_decode($json2, true);

        if ($result1['cod'] != '404') {
            $data = $result1;
        } else {
            $data = $result2;
        }

        //return data array()
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $data], 200);
    }

    public function display()
    {
        $api_key = env('OPENWEATHER_API_KEY');

        //get City
        $city = $this->setting->info['kota'];
        $cari = $this->model->find($city);
        $data1 = $cari['lokasi'];
        $pecah = explode(" ", $data1);
        $kota = ucfirst($pecah[1]);

        //get Provinsi
        $province = $this->setting->info['provinsi'];
        $cari = $this->provinsi->find($province);
        $data2 = $cari['provinsi'];
        $provinsi = $data2;

        if (@fsockopen('www.google.com', 80)) {
            if ($this->_isCurl()) {
                $json1 = $this->curlRequest("http://api.openweathermap.org/data/2.5/weather?appid=$api_key&units=metric&q=$kota", false);
            } else {
                $json1 = $this->fOpenRequest("http://api.openweathermap.org/data/2.5/weather?appid=$api_key&units=metric&q=$kota", false);
            }
        
            if ($this->_isCurl()) {
                $json2 = $this->curlRequest("http://api.openweathermap.org/data/2.5/weather?appid=$api_key&units=metric&q=$provinsi", false);
            } else {
                $json2 = $this->fOpenRequest("http://api.openweathermap.org/data/2.5/weather?appid=$api_key&units=metric&q=$provinsi", false);
            }
        } else {
            $json1 = "";
            $json2 = "";
        }

        //decode JSON to array
        $result1 = json_decode($json1, true);
        $result2 = json_decode($json2, true);

        if ($result1['cod'] != '404') {
            $data = $result1;
        } else {
            $data = $result2;
        }

        //return data array()
        return $this->respond(["status" => true, "message" => lang('App.getSuccess'), "data" => $data], 200);
    }
}
