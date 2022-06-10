<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'tb_penjualan';
    protected $primaryKey = 'id';
    // protected $returnType = 'object';
    protected $allowedFields = ['id', 'jenis', 'harga_jual', 'bibit_terjual', 'tanggal'];
}
