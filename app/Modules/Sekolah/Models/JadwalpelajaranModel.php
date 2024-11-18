<?php

namespace App\Modules\Sekolah\Models;

use CodeIgniter\Model;

class JadwalpelajaranModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jadwalpelajarans';
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

    public function getJadwalpelajaran($hari)
    {
        $this->select("{$this->table}.*, k.nama_kelas, j.mulai, j.selesai, g.nama_lengkap");
        $this->join("kelas k", "k.id = {$this->table}.id_kelas");
        $this->join("jampelajarans j", "j.jam_ke = {$this->table}.jam_ke");
        $this->join("gurus g", "g.id = {$this->table}.id_guru");
        $this->where("{$this->table}.hari", $hari);
        $this->orderBy("{$this->table}.id", "ASC");
        $query = $this->findAll();
        return $query;
    }

    public function guruMengajar($jam_ke, $hari){
		$this->select("{$this->table}.id_kelas, {$this->table}.id_guru, {$this->table}.jam_ke, k.nama_kelas, g.nama_lengkap, g.nip_nik, g.tempat_lahir, g.tanggal_lahir, g.foto, g.jabatan");
        $this->join("kelas k","{$this->table}.id_kelas=k.id");
        $this->join("gurus g","{$this->table}.id_guru=g.id");
        $this->where("{$this->table}.jam_ke", $jam_ke);
        $this->where("{$this->table}.hari", $hari);
        $this->orderBy("{$this->table}.id","ASC");
        $query = $this->findAll();
		return $query;
	}
}
