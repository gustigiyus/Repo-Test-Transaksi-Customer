<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterCustomer extends Model
{
    protected $table            = 'm_customer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode', 'nama', 'telp'];


    # FORMAT AUTO GENERATE KODE TRANSAKSI
    public function generete_kode_trans()
    {
        $query = $this->db->query("SELECT MAX(no_trans) as no_transaksi from t_sales");
        $hasil = $query->getRow();
        return $hasil->no_transaksi;
    }
}
