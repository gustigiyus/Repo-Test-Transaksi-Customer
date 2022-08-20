<?php

namespace App\Controllers;

use App\Models\DataTransBarang;
use App\Models\MasterCustomer;
use App\Models\MasterBarang;
use App\Models\DataTransCustomer;

class Transaksi extends BaseController
{
    protected $m_customer;
    protected $m_barang;
    protected $m_transBrng;
    protected $m_transCust;

    public function __construct()
    {
        $this->m_customer = new MasterCustomer();
        $this->m_barang = new MasterBarang();
        $this->m_transBrng = new DataTransBarang();
        $this->m_transCust = new DataTransCustomer();
    }

    public function index()
    {
        $data = [
            'title' => "Tranksaksi Customer Teknoindo",
            'trans_cust' => $this->m_transCust->getAllDataTransCustomer(),
            'trans_cust_total' => $this->m_transCust->getTotalBayarTransCustomer(),
        ];

        return view('transaksi/index', $data);
    }

    public function add()
    {
        // Format ID Karyawan
        $dariDB = $this->m_customer->generete_kode_trans();
        if ($dariDB == !NULL) {
            $nourut = substr($dariDB, 7, 4);
            $noTrans = $nourut + 1;
            $no_transaksi = $noTrans;
        } else {
            $noTrans = 0001;
            $no_transaksi = $noTrans;
        }

        $data = [
            'title' => 'Tambah Transaksi Barang',
            'm_customer' => $this->m_customer->findAll(),
            'm_barang' => $this->m_barang->findAll(),
            'no_trans' =>  $no_transaksi
        ];

        return view('transaksi/add3/add3', $data);
    }

    public function prosesAdd()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'no_trans' => [
                    'label' => 'No Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'kode_barang' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'id_barang' => [
                    'label' => 'ID Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'harga_bandrol' => [
                    'label' => 'Harga Bandrol',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'qty' => [
                    'label' => 'Quantity',
                    'rules' => 'required|greater_than_equal_to[1]|',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                        'greater_than_equal_to' => '{field} harus berisi minimal 1 buah atau lebih',
                    ]
                ],
                'dis_persen' => [
                    'label' => 'Diskon Persen',
                    'rules' => 'greater_than_equal_to[0]|integer|required|less_than_equal_to[100]',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                        'greater_than_equal_to' => '{field} harus berisi angka 0 atau lebih dari 0',
                        'less_than_equal_to' => '{field} tidak boleh lebih dari 100',
                        'integer' => '{field} harus berisi angka',
                    ]
                ],
                'dis_nilai' => [
                    'label' => 'Diskon Nilai',
                    'rules' => 'greater_than_equal_to[0]|integer|required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                        'greater_than_equal_to' => '{field} harus berisi angka 0 atau lebih',
                        'integer' => '{field} harus berisi angka',
                    ]
                ],
                'harga_diskon' => [
                    'label' => 'Harga Diskon',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'harga_total' => [
                    'label' => 'Harga Total',
                    'rules' => 'required|greater_than[0]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'greater_than' => 'Setidaknya {field} tidak boleh kurang dari 1 buah',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'no_trans' => $validation->getError('no_trans'),
                        'kode_barang' => $validation->getError('kode_barang'),
                        'barang_id' => $validation->getError('id_barang'),
                        'harga_bandrol' => $validation->getError('harga_bandrol'),
                        'qty' => $validation->getError('qty'),
                        'diskon_pct' => $validation->getError('dis_persen'),
                        'diskon_nilai' => $validation->getError('dis_nilai'),
                        'harga_diskon' => $validation->getError('harga_diskon'),
                        'total' => $validation->getError('harga_total'),
                    ]
                ];
                echo json_encode($msg);
            } else {
                $simpanData = [
                    'no_trans' => $this->request->getVar('no_trans'),
                    'barang_id' => $this->request->getVar('id_barang'),
                    'harga_bandrol' => $this->request->getVar('harga_bandrol'),
                    'qty' => $this->request->getVar('qty'),
                    'diskon_pct' => $this->request->getVar('dis_persen'),
                    'diskon_nilai' => $this->request->getVar('dis_nilai'),
                    'harga_diskon' => $this->request->getVar('harga_diskon'),
                    'total' => $this->request->getVar('harga_total'),
                ];

                $barang = $this->m_transBrng->insert($simpanData);

                $msg = [
                    'sukses' => 'Data Barang berhasil disimpan',
                    'no_trans' => $this->request->getVar('no_trans'),
                ];
                echo json_encode($msg);
            }
        } else {
            exit('Maaf data tidak dapat diakses');
        }
    }

    public function dataBarang3()
    {
        if ($this->request->isAJAX()) {
            $noTrans = $this->request->getVar('nomer_transaksi');
            $data = [
                'data_trans_barang' => $this->m_transBrng->getAllDataBarang($noTrans),
                'getTotalHarga' => $this->m_transBrng->getTotalHarga($noTrans),
            ];

            $msg = [
                'data_view' => view('transaksi/add3/view_databarang3', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf data tidak dapat diakses');
        }
    }

    public function prosesTransCustomer()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'no_trans' => [
                    'label' => 'No Transaksi',
                    'rules' => 'required|is_unique[t_sales.no_trans]',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                        'is_unique' => '{field} Sudah ada pada database',
                    ]
                ],
                'tgl' => [
                    'label' => 'Tanggal Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'id_cust' => [
                    'label' => 'Customer ID',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'subTotal' => [
                    'label' => 'Subtotal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'diskon' => [
                    'label' => 'Diskon',
                    'rules' => 'greater_than_equal_to[0]|integer',
                    'errors' => [
                        'greater_than_equal_to' => '{field} harus berisi angka 0 atau lebih dari 0',
                        'integer' => '{field} harus berisi angka',
                    ]
                ],
                'ongkir' => [
                    'label' => 'Ongkir',
                    'rules' => 'greater_than_equal_to[0]|integer',
                    'errors' => [
                        'greater_than_equal_to' => '{field} harus berisi angka 0 atau lebih dari 0',
                        'integer' => '{field} harus berisi angka',
                    ]
                ],
                'total_bayar' => [
                    'label' => 'Total Bayar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'jumlah_barang' => [
                    'label' => 'Jumlah Barang',
                    'rules' => 'required|greater_than[0]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'greater_than' => 'Setidaknya {field} tidak boleh kurang dari 1 buah',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'no_trans' => $validation->getError('no_trans'),
                        'tgl' => $validation->getError('tgl'),
                        'cust_id' => $validation->getError('id_cust'),
                        'subtotal' => $validation->getError('subTotal'),
                        'diskon' => $validation->getError('diskon'),
                        'ongkir' => $validation->getError('ongkir'),
                        'total_bayar' => $validation->getError('total_bayar'),
                        'jumlah_barang' => $validation->getError('jumlah_barang'),
                    ]
                ];
                echo json_encode($msg);
            } else {
                $simpanData = [
                    'no_trans' => $this->request->getVar('no_trans'),
                    'tgl' => $this->request->getVar('tgl'),
                    'cust_id' => $this->request->getVar('id_cust'),
                    'subtotal' => $this->request->getVar('subTotal'),
                    'diskon' => $this->request->getVar('diskon'),
                    'ongkir' => $this->request->getVar('ongkir'),
                    'total_bayar' => $this->request->getVar('total_bayar'),
                    'jumlah_barang' => $this->request->getVar('jumlah_barang'),
                ];

                $data_transaksi_customer = $this->m_transCust->insert($simpanData);

                $msg = [
                    'pesan' => 'Data Transaksi Customer berhasil disimpan',
                ];
                echo json_encode($msg);
            }
        } else {
            exit('Maaf data tidak dapat diakses');
        }
    }

    public function editBarang()
    {
        if ($this->request->isAJAX()) {
            $id_barang = $this->request->getVar('id');
            $rowBarang = $this->m_transBrng->getSatuDataBarang($id_barang);

            $data = [
                'sales_id' => $rowBarang->sales_id,
                'no_trans' => $rowBarang->no_trans,
                'barang_id' => $rowBarang->barang_id,
                'nama' => $rowBarang->nama,
                'kode' => $rowBarang->kode,
                'harga_bandrol' => $rowBarang->harga_bandrol,
                'qty' => $rowBarang->qty,
                'diskon_pct' => $rowBarang->diskon_pct,
                'diskon_nilai' => $rowBarang->diskon_nilai,
                'harga_diskon' => $rowBarang->harga_diskon,
                'total' => $rowBarang->total,
                'kode_semua_barang' =>  $this->m_barang->findAll()
            ];

            $msg = [
                'sukses' => view('transaksi/add3/modal_edit', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf data tidak dapat diakses');
        }
    }

    public function prosesUpdateBarang($id)
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'no_trans' => [
                    'label' => 'No Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'id_barang' => [
                    'label' => 'ID Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'harga_bandrol' => [
                    'label' => 'Harga Bandrol',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'qty' => [
                    'label' => 'Quantity',
                    'rules' => 'required|greater_than_equal_to[1]',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                        'greater_than_equal_to' => '{field} harus berisi minimal 1 buah atau lebih',
                    ]
                ],
                'dis_persen' => [
                    'label' => 'Diskon Persen',
                    'rules' => 'greater_than_equal_to[0]|integer|required|less_than_equal_to[100]',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                        'greater_than_equal_to' => '{field} harus berisi angka 0 atau lebih dari 0',
                        'less_than_equal_to' => '{field} tidak boleh lebih dari 100',
                        'integer' => '{field} harus berisi angka',
                    ]
                ],
                'dis_nilai' => [
                    'label' => 'Diskon Nilai',
                    'rules' => 'greater_than_equal_to[0]|integer|required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                        'greater_than_equal_to' => '{field} harus berisi angka 0 atau lebih',
                        'integer' => '{field} harus berisi angka',
                    ]
                ],
                'harga_diskon' => [
                    'label' => 'Harga Diskon',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong',
                    ]
                ],
                'harga_total' => [
                    'label' => 'Harga Total',
                    'rules' => 'required|greater_than[0]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'greater_than' => 'Setidaknya {field} tidak boleh kurang dari 1 buah',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'no_trans' => $validation->getError('no_trans'),
                        'barang_id' => $validation->getError('id_barang'),
                        'harga_bandrol' => $validation->getError('harga_bandrol'),
                        'qty' => $validation->getError('qty'),
                        'diskon_pct' => $validation->getError('dis_persen'),
                        'diskon_nilai' => $validation->getError('dis_nilai'),
                        'harga_diskon' => $validation->getError('harga_diskon'),
                        'total' => $validation->getError('harga_total'),
                    ]
                ];
                echo json_encode($msg);
            } else {
                $simpanData = [
                    'no_trans' => $this->request->getVar('no_trans'),
                    'barang_id' => $this->request->getVar('id_barang'),
                    'harga_bandrol' => $this->request->getVar('harga_bandrol'),
                    'qty' => $this->request->getVar('qty'),
                    'diskon_pct' => $this->request->getVar('dis_persen'),
                    'diskon_nilai' => $this->request->getVar('dis_nilai'),
                    'harga_diskon' => $this->request->getVar('harga_diskon'),
                    'total' => $this->request->getVar('harga_total'),
                ];

                $barang = $this->m_transBrng->update($id, $simpanData);

                $msg = [
                    'sukses' => 'Data Barang berhasil diupdate',
                    'no_trans' => $this->request->getVar('no_trans'),
                ];
                echo json_encode($msg);
            }
        } else {
            exit('Maaf data tidak dapat diakses');
        }
    }

    public function delete($id)
    {
        $this->m_transBrng->delete($id);
        session()->setFlashdata('pesan', 'Data barang berhasil dihapus');
        return redirect()->to('/transaksi/add');
    }

    // GET DATA MASTER (CUSTOMER & BARANG)
    public function get_data_cust()
    {

        if ($this->request->isAJAX()) {
            $query = service('request')->getPost('cust_code');
            $data_cust = $this->m_customer->where('kode', $query)->findAll();
            return json_encode(['cust' => $data_cust]);
        }
    }

    public function get_data_barang()
    {

        if ($this->request->isAJAX()) {
            $query = service('request')->getPost('brng_code');
            $data_brng = $this->m_barang->where('kode', $query)->findAll();
            return json_encode(['barang' => $data_brng]);
        }
    }
}
