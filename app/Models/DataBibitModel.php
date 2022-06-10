<?php

namespace App\Models;

use CodeIgniter\Model;

class DataBibitModel extends Model
{
    protected $table = 'tb_databibit';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'jenis', 'tanggal', 'jml_stok'];
}
