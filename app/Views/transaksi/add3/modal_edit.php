<!-- Modal Ubah Barang -->
<div class="modal fade" id="modalUbahDataBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticUabhBarang" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticUabhBarang">Ubah Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('transaksi/prosesUpdateBarang/' . $sales_id, ['class' => 'ubahBarang']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <!-- -Parameter ID BARANG -->
                <div class="mb-3 row" hidden>
                    <label for="id_barang_edit" class="col-sm-3 col-form-label fw-bold">ID Barang</label>
                    <div class="col-sm-9">
                        <input type="text" name="id_barang" id="id_barang_edit" value="<?= $barang_id; ?>" class="form-control">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="no_trans" class="col-sm-3 col-form-label fw-bold">No Trans</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="no_trans" id="no_trans" value="<?= $no_trans ?>" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="kode_barang" class="col-sm-3 col-form-label fw-bold">Kode Barang</label>
                    <div class="col-sm-9">
                        <select name="kode_barang" id="kode_barang" class="form-control" autofocus required>
                            <option value="<?= $kode; ?>"><?= $kode; ?></option>
                            <option value="">- Pilih -</option>
                            <?php foreach ($kode_semua_barang as $m_brg) : ?>
                                <option value="<?= $m_brg->kode; ?>"><?= $m_brg->kode; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama_barang_edit" class="col-sm-3 col-form-label fw-bold">Nama Barang</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama_barang" id="nama_barang_edit" value="<?= $nama ?>" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga_bandrol_edit" class="col-sm-3 col-form-label fw-bold">Harga Bandrol</label>
                    <div class="col-sm-9">
                        <input type="text" name="harga_bandrol" id="harga_bandrol_edit" value="<?= $harga_bandrol ?>" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="qty_edit" class="col-sm-3 col-form-label fw-bold">Quantity</label>
                    <div class="col-sm-9">
                        <input type="number" name="qty" id="qty_edit" value="<?= $qty; ?>" placeholder="Masukan quantity barang" class="form-control">
                        <div class="text-danger" id="errorQuantity">
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="dis_persen_edit" class="col-sm-3 col-form-label fw-bold">Diskon Persen (%)</label>
                    <div class="col-sm-9">
                        <input type="number" name="dis_persen" id="dis_persen_edit" value="<?= $diskon_pct; ?>" placeholder="Masukan diskon persen (%)" class="form-control">
                        <div class="text-danger" id="errorDiskonPersen">
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="dis_nilai_edit" class="col-sm-3 col-form-label fw-bold">Diskon Nilai</label>
                    <div class="col-sm-9">
                        <input type="text" name="dis_nilai" id="dis_nilai_edit" value="<?= $diskon_nilai; ?>" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga_diskon_edit" class="col-sm-3 col-form-label fw-bold">Harga Diskon</label>
                    <div class="col-sm-9">
                        <input type="text" name="harga_diskon" id="harga_diskon_edit" value="<?= $harga_diskon; ?>" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga_total_edit" class="col-sm-3 col-form-label fw-bold">Total Harga</label>
                    <div class="col-sm-9">
                        <input type="text" name="harga_total" id="harga_total_edit" value="<?= $total; ?>" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnSimpan">Ubah Barang</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#dis_persen_edit').keyup(function() {
            let diskon_persen = parseInt($('#dis_persen_edit').val());
            let harga_bandrol = parseInt($('#harga_bandrol_edit').val());

            let total_discon_nilai = harga_bandrol * diskon_persen / 100;
            let total_harga_diskon = harga_bandrol - total_discon_nilai;

            let diskon_nilai = $('#dis_nilai_edit').val(total_discon_nilai)
            let harga_diskon = $('#harga_diskon_edit').val(total_harga_diskon)

            let harga_total = parseInt($('#harga_diskon_edit').val()) * parseInt($('#qty_edit').val());
            $('#harga_total_edit').val(harga_total);
        })

        $('#qty_edit').keyup(function() {
            let quantity = parseInt($('#qty_edit').val());
            let harga_diskon = parseInt($('#harga_diskon_edit').val());

            let harga_total = harga_diskon * quantity;
            $('#harga_total_edit').val(harga_total);
        })

    });


    $('#kode_barang').change(function() {
        let brng_code = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('transaksi/get_data_barang'); ?>",
            data: {
                brng_code: brng_code
            },
            dataType: "JSON",
            success: function(data) {
                $('#id_barang_edit').val(data.barang[0].id);
                $('#nama_barang_edit').val(data.barang[0].nama);
                $('#harga_bandrol_edit').val(data.barang[0].harga);

                let harga_bandrol = parseInt($('#harga_bandrol_edit').val());

                let diskon_persen = parseInt($('#dis_persen_edit').val());
                let total_discon_nilai = harga_bandrol * diskon_persen / 100;
                let total_harga_diskon = harga_bandrol - total_discon_nilai;

                let diskon_nilai = $('#dis_nilai_edit').val(total_discon_nilai)
                let harga_diskon = $('#harga_diskon_edit').val(total_harga_diskon)

                let harga_total = parseInt($('#harga_diskon_edit').val()) * parseInt($('#qty_edit').val());
                $('#harga_total_edit').val(harga_total);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })


    $(document).ready(function() {
        const not_trans = $('#no_trans').val();
        dataBarang(not_trans);

        $('.ubahBarang').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    $('.btnSimpan').attr('disable', 'disabled');
                    $('.btnSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnSimpan').removeAttr('disable');
                    $('.btnSimpan').html('Update');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.qty) {
                            $('#qty_edit').addClass('is-invalid');
                            $('#errorQuantity').addClass('invalid-feedback');
                            $('#errorQuantity').html(response.error.qty);
                        } else {
                            $('#qty_edit').removeClass('is-invalid');
                            $('#errorQuantity').removeClass('invalid-feedback');
                            $('#errorQuantity').html('');
                        }

                        if (response.error.diskon_pct) {
                            $('#dis_persen_edit').addClass('is-invalid');
                            $('#errorDiskonPersen').addClass('invalid-feedback');
                            $('#errorDiskonPersen').html(response.error.diskon_pct);
                        } else {
                            $('#dis_persen_edit').removeClass('is-invalid');
                            $('#errorDiskonPersen').removeClass('invalid-feedback');
                            $('#errorDiskonPersen').html('');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses,
                        });

                        $('#modalUbahDataBarang').modal('hide');
                        dataBarang(response.no_trans);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

            return false;
        });
    });
</script>