<?= $this->extend('templates/main'); ?>
<?= $this->section('content'); ?>

<main>
    <h1 class="visually-hidden">Heroes examples</h1>

    <div class="text-secondary text-center px-4 py-5" style="background-color: #273036;">
        <div class="py-4">
            <h1 class="col-lg-12 col-md-12 col-sm-12 mx-auto fw-bold text-white" style="font-size: 30px;">TRANSAKSI CUSTOMER TEKNOINDO</h1>
            <div class="col-lg-5 col-md-8 col-sm-10 mx-auto">
                <p class="mb-4" style="font-size: 15px;">Website ini merupkan digunkan untuk melengkapi test masuk sebagai junior programmer unutk PT. Mitra Sinerji Teknoindo.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="/" class="btn btn-outline-info btn-lg px-4 me-sm-3 fw-bold">Home</a>
                    <a href="<?= base_url('/transaksi/add'); ?>" class="btn btn-outline-light btn-lg px-4">Tansaksi</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="card shadow-lg">
            <div class="card-header">
                <h5 class="p-0 m-0 fw-bolder text-center">Tabel Transaksi Customer</h5>
                <!-- <div class="pencarian d-flex justify-content-end my-2">
                    <div class="col-md-12 row">
                        <div class="col-md-8 col-sm-6 d-flex justify-content-end align-items-center p-0">
                            <label class="fw-bold" style="font-size: 16px;">Date :</label>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <input type="text" placeholder="Cari Berdasarkan Tanggal..." class="form-control">
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="tableSales" class="display nowrap" style="width:100%">
                    <thead class="fw-bold table-primary">
                        <tr>
                            <th class="align-middle text-center">No</th>
                            <th class="align-middle text-center">No Transaksi</th>
                            <th class="align-middle text-center">Tanggal</th>
                            <th class="align-middle text-center">Nama Cust</th>
                            <th class="align-middle text-center">Jml Barang</th>
                            <th class="align-middle text-center">Sub Total</th>
                            <th class="align-middle text-center">Diskon</th>
                            <th class="align-middle text-center">Ongkir</th>
                            <th class="align-middle text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($trans_cust as $TCust) : ?>
                            <tr class="">
                                <td class="align-middle text-center fw-bold table-primary"><?= $no++ ?></td>
                                <td class="align-middle text-center"><?= $TCust->no_trans; ?></td>
                                <td class="align-middle text-center"><?= $TCust->tgl; ?></td>
                                <td class="align-middle text-center"><?= $TCust->name; ?></td>
                                <td class="align-middle text-center"><?= $TCust->jumlah_barang; ?></td>
                                <td class="align-middle text-center"><?= ($trans_cust > 0) ? format_rupah($TCust->subtotal) : ''; ?></td>
                                <td class="align-middle text-center"><?= ($trans_cust > 0) ? format_rupah($TCust->diskon) : ''; ?></td>
                                <td class="align-middle text-center"><?= ($trans_cust > 0) ? format_rupah($TCust->ongkir) : ''; ?></td>
                                <td class="align-middle text-center"><?= ($trans_cust > 0) ? format_rupah($TCust->total_bayar) : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-dark">
                        <td colspan="8" class="fw-bolder text-end">Grand Total</td>
                        <td class="fw-bolder align-middle text-center" style="color: red;"><?= ($trans_cust_total->total_bayar > 0) ? format_rupah($trans_cust_total->total_bayar) : 'Rp. 0';  ?></td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#tableSales').DataTable({
            responsive: true,
            scrollX: true,
            scrollCollapse: true,
            fixedHeader: {
                header: true,
            },
            fixedColumns: true,
            "columnDefs": [{
                "width": "15%",
                "targets": 8
            }]
        });
    });
</script>

<?php $this->endSection(); ?>