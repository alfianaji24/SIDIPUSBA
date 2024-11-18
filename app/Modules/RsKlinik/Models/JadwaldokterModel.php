<?php

namespace App\Modules\RsKlinik\Models;

use CodeIgniter\Model;

class JadwaldokterModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jadwaldokters';
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

    public function getJadwaldokter($hari)
    {
        $this->select("{$this->table}.*, r.nama_ruang, j.mulai, j.selesai, d.nama_lengkap");
        $this->join("ruangs r", "r.id = {$this->table}.id_ruang");
        $this->join("jampelayanans j", "j.jam_ke = {$this->table}.jam_ke");
        $this->join("dokters d", "d.id = {$this->table}.id_dokter");
        $this->where("{$this->table}.hari", $hari);
        $this->orderBy("{$this->table}.id", "ASC");
        $query = $this->findAll();
        return $query;
    }

    public function getJadwaldokterHari($hari) 
    {
        $this->select("{$this->table}.*, d.nama_lengkap, r.nama_ruang, jp.mulai, jp.selesai");
        $this->join("dokters d", "d.id = {$this->table}.id_dokter");
        $this->join("ruangs r", "r.id = {$this->table}.id_ruang");
        $this->join("jampelayanans jp", "jp.jam_ke = {$this->table}.jam_ke");
        $this->where("{$this->table}.hari", $hari);
        $this->orderBy("{$this->table}.id", "ASC");
        $query = $this->findAll();
        return $query;
    }

    public function dokterPraktek($hari){
		$this->select("{$this->table}.id_ruang, {$this->table}.id_dokter, {$this->table}.jam_ke, r.nama_ruang, d.nama_lengkap, d.nip_nik, d.tempat_lahir, d.tanggal_lahir, d.foto, d.spesialis, jp.mulai, jp.selesai");
        $this->join("ruangs r","{$this->table}.id_ruang=r.id");
        $this->join("dokters d","{$this->table}.id_dokter=d.id");
        $this->join("jampelayanans jp", "jp.jam_ke = {$this->table}.jam_ke");
        $this->where("{$this->table}.hari", $hari);
        $this->orderBy("{$this->table}.id","ASC");
        $query = $this->findAll();
		return $query;
	}
}
