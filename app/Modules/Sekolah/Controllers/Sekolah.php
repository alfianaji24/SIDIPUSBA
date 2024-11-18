<?php

namespace  App\Modules\Sekolah\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;
use App\Modules\Sekolah\Models\JampelajaranModel;

class Sekolah extends BaseController
{
	protected $setting;
	protected $jam;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
		$this->jam = new JampelajaranModel();
		//memanggil Helper
		helper('disfo');
	}

	public function guru()
	{
		return view('App\Modules\Sekolah\Views/guru', [
			'title' => 'Guru',
			'uploadSize' => '50 MB',
			'maxsizeInfo' => max_file_upload_in_bytes(),
		]);
	}

	public function kelas()
	{
		return view('App\Modules\Sekolah\Views/kelas', [
			'title' => 'Kelas'
		]);
	}

	public function hariBelajar()
	{
		return view('App\Modules\Sekolah\Views/haribelajar', [
			'title' => 'Setup Hari Belajar',
			'dataJam' => $this->jam->orderBy('jam_ke','ASC')->findAll(),
		]); 
	}

	public function jamPelajaran()
	{
		return view('App\Modules\Sekolah\Views/jampelajaran', [
			'title' => 'Jam Pelajaran'
		]);
	}

	public function jadwalPelajaran()
	{
		return view('App\Modules\Sekolah\Views/jadwalpelajaran', [
			'title' => 'Jadwal Pelajaran'
		]);
	}

}
