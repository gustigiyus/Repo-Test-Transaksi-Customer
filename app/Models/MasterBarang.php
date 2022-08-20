<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterBarang extends Model
{
    protected $table            = 'm_barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode', 'nama', 'harga'];
}
