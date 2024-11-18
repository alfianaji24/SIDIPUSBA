<?php

namespace App\Modules\Masjid\Models;

use CodeIgniter\Model;

class JadwalsholatModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jadwalsholats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getJadwalsholat($idbulan, $start, $end)
    {
        $this->select("{$this->table}.*");
        $this->where("{$this->table}.id_bulan", $idbulan);
        $this->orWhere("DATE({$this->table}.date) BETWEEN '$start' AND '$end'", null, false);
        $query = $this->findAll();
        return $query;
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
    
    function getApijadwalsholat($city, $tahun, $bulan, $tanggal)
	{
		//get JSON
		//you can get param appid from your account in openweathermap.org
		//http://api.openweathermap.org/data/2.5/weather?appid=[YOUR_APP_ID]&units=metric&q=$city

		/* $cari = $this->curlRequest("https://api.myquran.com/v2/sholat/jadwal/$city/2022/05/19", false);
		$result = json_decode($cari, true);
		$data = $result['data']['jadwal'];
		var_dump($data);
		die; */

		if (@fsockopen('www.google.com', 80)) {
			if ($this->_isCurl()) {
				$json = $this->curlRequest("https://api.myquran.com/v2/sholat/jadwal/$city/$tahun/$bulan/$tanggal", false);
			} else {
				$json = $this->fOpenRequest("https://api.myquran.com/v2/sholat/jadwal/$city/$tahun/$bulan/$tanggal", false);
			}
		} else {
			$json = [];
		}
		
		if (!empty($json)) {
			//decode JSON to array
			$result = json_decode($json, true);
			$data = $result['data']['jadwal'];
		} else {
			$data = [];
		}
		//return data array()
		return $data;
	}
}
