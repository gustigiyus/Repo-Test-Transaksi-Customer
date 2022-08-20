<div class="table-responsive">
    <table class="table mt-4 tb_trans" id="tableBarang">
        <thead class="fw-bold text-white text-center" style="background-color: blue;">
            <tr>
                <th rowspan="2" colspan="2" class="align-middle">
                    <button type="button" class="btn btn-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalSelectBarang">
                        TAMBAH BARANG
                    </button>
                </th>
                <th rowspan="2" class="align-middle">No Transaksi</th>
                <th rowspan="2" class="align-middle">Kode Barang</th>
                <th rowspan="2" class="align-middle">Nama Barang</th>
                <th rowspan="2" class="align-middle">Qty</th>
                <th rowspan="2" class="align-middle">Harga Bandrol</th>
                <th colspan="2" class="align-middle">Diskon</th>
                <th rowspan="2" class="align-middle">Harga Diskon</th>
                <th rowspan="2" class="align-middle">Total</th>
            </tr>
            <tr>
                <th class="align-middle">(%)</th>
                <th class="align-middle">(Rp)</th>
            </tr>
        </thead>
        <?php $jumlah_barang = 0; ?>
        <?php foreach ($data_trans_barang as $d_brng) : ?>
            <tbody class="fw-bold text-dark table-light table-group-divider" align="center">
                <tr>
                    <td class="align-middle">
                        <button type="button" class="btn btn-warning text-light fw-bold" onclick="ubahDataBarang('<?= $d_brng->sales_id; ?>')">Ubah
                        </button>
                    </td>
                    <td class="align-middle">
                        <form action="<?= base_url('/transaksi/delete/' . $d_brng->sales_id); ?>" method="post" class="d-inline" id="form_delete">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger text-light fw-bold" onclick="deleteBarang()">Delete</button>
                        </form>
                    </td>
                    <td class="align-middle"><?= $d_brng->no_trans ?></td>
                    <td class="align-middle"><?= $d_brng->kode ?></td>
                    <td class="align-middle"><?= $d_brng->nama ?></td>
                    <td class="align-middle"><?= $d_brng->qty ?></td>
                    <td class="align-middle"><?= format_rupah($d_brng->harga_bandrol) ?></td>
                    <td class="align-middle"><?= $d_brng->diskon_pct ?>%</td>
                    <td class="align-middle"><?= format_rupah($d_brng->diskon_nilai) ?></td>
                    <td class="align-middle"><?= format_rupah($d_brng->harga_diskon) ?></td>
                    <td class="align-middle"><?= format_rupah($d_brng->total) ?></td>
                </tr>
            </tbody>
            <?php $jumlah_barang += 1; ?>
        <?php endforeach; ?>
        <tfoot class="fw-bold text-white table-dark">
            <tr>
                <th colspan="11" style="height: 20px;" class="align-middle">
                    <input hidden id="jumlah_barang" name="jumlah_barang" class="form-control" value="<?= $jumlah_barang; ?>" required>
                    <div class="text-danger fs-5" id="errorJumlahBarang">
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="6"></th>
                <th>Sub Total </th>
                <th colspan="4">
                    <input type="number" name="subTotal" id="subTotal" class="form-control" value="<?= $getTotalHarga->total; ?>" style="background-color: #c0c7bf; border: 1px solid black; cursor: not-allowed;" readonly>
                    <div class="text-danger" id="errorSubTotal">
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="6"></th>
                <th>Diskon</th>
                <th colspan="4">
                    <input type="text" min="0" placeholder="Masukan Diskon Rp.000.000.000" name="diskon" id="diskon" class="form-control" value="0">
                    <div class="text-danger" id="errorDiskon">
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="6"></th>
                <th>Ongkir</th>
                <th colspan="4">
                    <input type="text" min="0" placeholder="Masukan Ongkir" name="ongkir" id="ongkir" class="form-control" value="0">
                    <div class="text-danger" id="errorOngkir">
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="6"></th>
                <th>Total Bayar</th>
                <th colspan="4">
                    <input type="number" name="total_bayar" id="totalBayar" class="form-control" value="<?= $getTotalHarga->total; ?>" style="background-color: #c0c7bf; border: 1px solid black; cursor: not-allowed;" readonly>
                    <div class="text-danger" id="errorTotalBayar">
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="11" style="height: 20px;"></th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    function ubahDataBarang(id) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('/transaksi/editBarang') ?>",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(response) {
                if (response.sukses) {
                    $('.ubahDataModal').html(response.sukses).show();
                    $('#modalUbahDataBarang').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        let subTotal = document.querySelector('#subTotal').value;

        $('#diskon').keyup(function() {
            let a = parseInt($('#diskon').val());
            let b = parseInt($('#ongkir').val());
            let c = (a + b);
            let Tot = subTotal - c
            $('#totalBayar').val(Tot);
        })

        $('#ongkir').keyup(function() {
            let a = parseInt($('#diskon').val());
            let b = parseInt($('#ongkir').val());
            let c = (a + b);
            let Tot = subTotal - c
            $('#totalBayar').val(Tot);
        })
    });
</script>


<script>
    function deleteBarang() {
        event.preventDefault();
        let form = event.target.form;
        swal.fire({
            title: "Apakah anda yakin ingin menghapus data ini?",
            text: "Data yang telah terhapus tidak bisa dikembalikan.",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus data!",
            cancelButtonText: "Tidak!, Jangan sekarang!",
        }).then((result) => {
            if (result.isConfirmed) {
                setTimeout(function() {
                    form.submit();
                }, 1500);
                smoothScroll({
                    yPos: 0,
                    duration: 1500
                });
            } else {
                swal.fire("Gagal", "Data barang gagal dihapus", "error");
            }
        })
    }
</script>