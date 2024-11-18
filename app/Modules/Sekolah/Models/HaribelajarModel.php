<?php

namespace App\Modules\Sekolah\Models;

use CodeIgniter\Model;

class HaribelajarModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'haribelajars';
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

    public function getHariJamBelajar($hari)
    {
        if (!empty($hari)) {
            $this->select("{$this->table}.id, {$this->table}.$hari, j.jam_ke, j.mulai, j.selesai");
            $this->join("jampelajarans j", "j.id = {$this->table}.id_jampelajaran");
            $this->where("{$this->table}.$hari", '2'); //2 = KBM
            $this->orderBy("{$this->table}.id", "ASC");
            $query = $this->findAll();
        } else {
            $query = [];
        }
        return $query;
    }
}
