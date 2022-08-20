<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTransCustomer extends Model
{
    protected $table            = 't_sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['no_trans', 'tgl', 'cust_id', 'subtotal', 'jumlah_barang', 'diskon', 'ongkir', 'total_bayar'];

    public function getAllDataTransCustomer()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('t_sales');
        $builder->select('*');
        $builder->join('m_customer', 'm_customer.id = t_sales.cust_id');
        return $builder->get()->getResult();
    }

    public function getTotalBayarTransCustomer()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('t_sales');
        $builder->selectSum('total_bayar');
        return $builder->get()->getFirstRow();
    }
}
