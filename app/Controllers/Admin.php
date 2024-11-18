<?php

namespace App\Controllers;

use App\Libraries\Settings;
use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Spipu\Html2Pdf\Html2Pdf;

class Admin extends BaseController
{
    protected $setting;
    protected $userModel;

    public function __construct()
    {
        //memeriksa session role selain Admin redirect ke /
        if (session()->get('logged_in') == true && session()->get('role') == 2) {
            header('location:/');
            exit();
        }

        //memanggil Model
        $this->userModel = new UserModel();
        $this->setting = new Settings();
    }

    public function index()
    {
        //memanggil function di model
        $user = $this->userModel->countAllResults();

        return view('admin/index', [
            'jmlUser' => $user,
            'title' => 'Dashboard',
        ]);
    }

    public function user()
    {
        return view('admin/user', [
            'title' => $this->setting->info['nama_aplikasi'],
        ]);
    }
}
