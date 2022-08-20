<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTransBarang extends Model
{
    protected $table            = 't_seles_det';
    protected $primaryKey       = 'sales_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['no_trans', 'barang_id', 'harga_bandrol', 'qty', 'diskon_pct', 'diskon_nilai', 'harga_diskon', 'total'];


    public function getTotalHarga($noTrans)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('t_seles_det');
        $builder->selectSum('total');
        $builder->where('no_trans', $noTrans);
        return $builder->get()->getFirstRow();
    }

    public function getAllDataBarang($noTrans)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('t_seles_det');
        $builder->select('*');
        $builder->join('m_barang', 'm_barang.id = t_seles_det.barang_id');
        $builder->where('no_trans', $noTrans);
        return $builder->get()->getResult();
    }

    public function getSatuDataBarang($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('t_seles_det');
        $builder->select('*');
        $builder->join('m_barang', 'm_barang.id = t_seles_det.barang_id');
        $builder->where('sales_id', $id);
        return $builder->get()->getFirstRow();
    }
}
