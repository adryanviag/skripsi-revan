<?php

namespace App\Models;

use CodeIgniter\Model;

class PrediksiModel extends Model
{
    protected $table = 'tb_prediksi';
    protected $primaryKey = 'id';
    // protected $returnType = 'object';
    protected $allowedFields = ['id', 'id_penjualan', 'harga_prediksi', 'tanggal_prediksi', 'alpha'];
}
