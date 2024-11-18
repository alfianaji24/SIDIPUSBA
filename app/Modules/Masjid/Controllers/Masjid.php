<?php

namespace  App\Modules\Masjid\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Settings;
use CodeIgniter\I18n\Time;

class Masjid extends BaseController
{
	protected $setting;

	public function __construct()
	{
		//memanggil Model
		$this->setting = new Settings();
	}

	public function jadwalSholat()
	{
		return view('App\Modules\Masjid\Views/jadwalsholat', [
			'title' => 'Jadwal Sholat',
			'modejadwalSholat' => $this->setting->info['jadwal_sholat'],
			'startDate' => date('Y-m-', strtotime(Time::now())) . '01',
            'endDate' => date('Y-m-t', strtotime(Time::now())),
		]);
	}

	public function agamaQuotes()
	{
		return view('App\Modules\Masjid\Views/agamaquotes', [
			'title' => 'Quotes Agama'
		]);
	}

	public function keuanganMasjid()
	{
		return view('App\Modules\Masjid\Views/keuanganmasjid', [
			'title' => 'Keuangan Masjid',
		]);
	}
}
