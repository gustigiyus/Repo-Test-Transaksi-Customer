<?= $this->extend('templates/main'); ?>
<?= $this->section('content'); ?>

<main>
    <h1 class="visually-hidden">Heroes examples</h1>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="flash-dataSukses" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>
    <?php endif; ?>

    <?= form_open('transaksi/prosesTransCustomer', ['class' => 'formTransCustomer']) ?>
    <div class="text-secondary px-4 py-2" style="background-color: #273036;">
        <div class="py-4">
            <div class="container">
                <?= csrf_field(); ?>
                <div class="input-box">
                    <div class="input-transaksi">
                        <label class="col-md-7 col-sm-12 col-form-label p-2 mb-3 fw-bolder text-dark rounded" style="background-color: lightblue;">Transaksi</label>
                        <div class="mb-3 row">
                            <label for="no_trans" class="col-sm-2 col-md-1 col-form-label fw-bold text-white">No</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" class="form-control" name="no_trans" id="no_trans" value="202201-<?php echo sprintf("%04s", $no_trans) ?>" readonly style="background-color: #c0c7bf; border: 1px solid black; cursor: not-allowed;">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tgl" class="col-sm-2 col-md-1 col-form-label fw-bold text-white">Tanggal</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="datetime-local" placeholder="Pilih Tanggal Transaksi" class="form-control" id="tgl" name="tgl" required>
                            </div>
                        </div>
                    </div>

                    <div class="input-customer">
                        <label class="col-md-7 col-sm-12 col-form-label p-2 mb-3 fw-bolder text-dark rounded" style="background-color: lightblue;">Customer</label>
                        <div class="mb-3 row">
                            <label for="kode" class="col-sm-2 col-md-1 col-form-label fw-bold text-white">Kode</label>
                            <div class="col-sm-10 col-md-4">
                                <select class="form-control" name="kode_cust" id="kode_cust" style="cursor: pointer;" required>
                                    <option value="">Pilih Kode Customer</option>
                                    <?php foreach ($m_customer as $m_cust) : ?>
                                        <option value="<?= $m_cust->kode; ?>"><?= $m_cust->kode; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row" hidden>
                            <label for="id_cust" class="col-sm-2 col-md-1 col-form-label fw-bold text-white">ID Cust</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" class="form-control" name="id_cust" id="id_cust">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nama_cust" class="col-sm-2 col-md-1 col-form-label fw-bold text-white">Nama</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" class="form-control" name="nama_cust" id="nama_cust" required readonly style="background-color: #c0c7bf; border: 1px solid black; cursor: not-allowed;">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="telp_cust" class="col-sm-2 col-md-1 col-form-label fw-bold text-white">Telepon</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" class="form-control" name="telp_cust" id="telp_cust" required readonly style="background-color: #c0c7bf; border: 1px solid black; cursor: not-allowed;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 250">
        <path fill="#273036" fill-opacity="1" d="M0,160L30,144C60,128,120,96,180,106.7C240,117,300,171,360,160C420,149,480,75,540,58.7C600,43,660,85,720,96C780,107,840,85,900,112C960,139,1020,213,1080,202.7C1140,192,1200,96,1260,64C1320,32,1380,64,1410,80L1440,96L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z"></path>
    </svg>

    <div class="container mb-4">
        <div class="card text-center shadow-lg">
            <div class="card-header">
                <h5 class="card-title">Form Data Barang</h5>
            </div>
            <div class="card-body">
                <div id="data-barang">

                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="tombolform d-flex align-items-center justify-content-center gap-4 my-2">
                    <button type="submit" class="btn btn-success tombolKirimForm" style="width: 120px;">Kirim</button>
                    <a href="<?= base_url('/transaksi'); ?>" class="btn btn-secondary" style="width: 120px;">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</main>

<!-- Modal Ubah Data Barang -->
<div class="ubahDataModal" style="display: none;"></div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="modalSelectBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('transaksi/prosesAdd', ['class' => 'selectBarang']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <!-- -Parameter ID BARANG -->
                <div class="mb-3 row" hidden>
                    <label for="id_barang" class="col-sm-3 col-form-label fw-bold">ID Barang</label>
                    <div class="col-sm-9">
                        <input type="text" name="id_barang" id="id_barang" value="" class="form-control">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="no_trans" class="col-sm-3 col-form-label fw-bold">ID Seles</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="no_trans" id="no_trans" value="202201-<?php echo sprintf("%04s", $no_trans) ?>" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="kode_barang" class="col-sm-3 col-form-label fw-bold">Kode Barang</label>
                    <div class="col-sm-9">
                        <select name="kode_barang" id="kode_barang" class="form-control" autofocus>
                            <option value="">- Pilih -</option>
                            <?php foreach ($m_barang as $m_brg) : ?>
                                <option value="<?= $m_brg->kode; ?>"><?= $m_brg->kode; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="text-danger" id="errorKodeBarangAdd">
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama_barang" class="col-sm-3 col-form-label fw-bold">Nama Barang</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama_barang" id="nama_barang" value="" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga_bandrol" class="col-sm-3 col-form-label fw-bold">Harga Bandrol</label>
                    <div class="col-sm-9">
                        <input type="text" name="harga_bandrol" id="harga_bandrol" value="" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="qty" class="col-sm-3 col-form-label fw-bold">Quantity</label>
                    <div class="col-sm-9">
                        <input type="number" name="qty" id="qty" placeholder="Masukan quantity barang" class="form-control">
                        <div class="text-danger" id="errorQuantityAdd">
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="dis_persen" class="col-sm-3 col-form-label fw-bold">Diskon Persen (%)</label>
                    <div class="col-sm-9">
                        <input type="number" name="dis_persen" id="dis_persen" placeholder="Masukan diskon persen (%)" class="form-control">
                        <div class="text-danger" id="errorDiskonPersenAdd">
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="dis_nilai" class="col-sm-3 col-form-label fw-bold">Diskon Nilai</label>
                    <div class="col-sm-9">
                        <input type="text" name="dis_nilai" id="dis_nilai" value="" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga_diskon" class="col-sm-3 col-form-label fw-bold">Harga Diskon</label>
                    <div class="col-sm-9">
                        <input type="text" name="harga_diskon" id="harga_diskon" value="" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga_total" class="col-sm-3 col-form-label fw-bold">Total Harga</label>
                    <div class="col-sm-9">
                        <input type="text" name="harga_total" id="harga_total" value="" class="form-control" readonly style="background-color: #c0c7bf; border: 1px solid black;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnPilih">Tambah Barang</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    const dataAlertSukses = $('.flash-dataSukses').data('flashdata');

    if (dataAlertSukses) {
        Swal.fire({
            toast: true,
            icon: 'success',
            title: dataAlertSukses,
            animation: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }

    //Datepicker - Flicker
    config = {
        allowInput: true,
        onOpen: function(selectedDates, dateStr, instance) {
            $(instance.altInput).prop('readonly', true);
        },
        onClose: function(selectedDates, dateStr, instance) {
            $(instance.altInput).prop('readonly', false);
            $(instance.altInput).blur();
        },


        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "today"
    };

    flatpickr("input[type=datetime-local]", config);


    //Form Data Transaksi Customer
    $('.formTransCustomer').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $('.tombolKirimForm').attr('disable', 'disabled');
                $('.tombolKirimForm').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.tombolKirimForm').removeAttr('disable');
                $('.tombolKirimForm').html('Simpan');
            },
            success: function(response) {
                if (response.error) {
                    if (response.error.subtotal) {
                        $('#subTotal').addClass('is-invalid');
                        $('#errorSubTotal').addClass('invalid-feedback');
                        $('#errorSubTotal').html(response.error.subtotal);
                    } else {
                        $('#subTotal').removeClass('is-invalid');
                        $('#errorSubTotal').removeClass('invalid-feedback');
                        $('#errorSubTotal').html('');
                    }

                    if (response.error.diskon) {
                        $('#diskon').addClass('is-invalid');
                        $('#errorDiskon').addClass('invalid-feedback');
                        $('#errorDiskon').html(response.error.diskon);
                    } else {
                        $('#diskon').removeClass('is-invalid');
                        $('#errorDiskon').removeClass('invalid-feedback');
                        $('#errorDiskon').html('');
                    }

                    if (response.error.ongkir) {
                        $('#ongkir').addClass('is-invalid');
                        $('#errorOngkir').addClass('invalid-feedback');
                        $('#errorOngkir').html(response.error.ongkir);
                    } else {
                        $('#ongkir').removeClass('is-invalid');
                        $('#errorOngkir').removeClass('invalid-feedback');
                        $('#errorOngkir').html('');
                    }

                    if (response.error.total_bayar) {
                        $('#totalBayar').addClass('is-invalid');
                        $('#errorTotalBayar').addClass('invalid-feedback');
                        $('#errorTotalBayar').html(response.error.total_bayar);
                    } else {
                        $('#totalBayar').removeClass('is-invalid');
                        $('#errorTotalBayar').removeClass('invalid-feedback');
                        $('#errorTotalBayar').html('');
                    }

                    if (response.error.jumlah_barang) {
                        $('#jumlah_barang').addClass('is-invalid');
                        $('#errorJumlahBarang').addClass('invalid-feedback');
                        $('#errorJumlahBarang').html(response.error.jumlah_barang);
                    } else {
                        $('#jumlah_barang').removeClass('is-invalid');
                        $('#errorJumlahBarang').removeClass('invalid-feedback');
                        $('#errorJumlahBarang').html('');
                    }

                } else {
                    const toastMixin = Swal.mixin({
                        toast: true,
                        icon: 'success',
                        title: 'General Title',
                        animation: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    toastMixin.fire({
                        animation: true,
                        title: response.pesan
                    });

                    setTimeout(function() {
                        $('.tombolKirimForm').attr('disabled', true);
                        window.location.href = "<?= site_url('/transaksi') ?>";
                    }, 4000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });


    function dataBarang(nomer_transaksi) {
        $.ajaxSetup({
            cache: false
        });
        $.ajax({
            url: "<?= site_url('transaksi/dataBarang3') ?>",
            dataType: "JSON",
            type: "POST",
            data: {
                nomer_transaksi: nomer_transaksi,
            },
            success: function(response) {
                $('#data-barang').empty().html(response.data_view);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    };


    $(document).ready(function() {
        const not_trans = $('#no_trans').val();
        dataBarang(not_trans);

        $('.selectBarang').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    $('.btnPilih').attr('disable', 'disabled');
                    $('.btnPilih').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnPilih').removeAttr('disable');
                    $('.btnPilih').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.qty) {
                            $('#qty').addClass('is-invalid');
                            $('#errorQuantityAdd').addClass('invalid-feedback');
                            $('#errorQuantityAdd').html(response.error.qty);
                        } else {
                            $('#qty').removeClass('is-invalid');
                            $('#errorQuantityAdd').removeClass('invalid-feedback');
                            $('#errorQuantityAdd').html('');
                        }

                        if (response.error.diskon_pct) {
                            $('#dis_persen').addClass('is-invalid');
                            $('#errorDiskonPersenAdd').addClass('invalid-feedback');
                            $('#errorDiskonPersenAdd').html(response.error.diskon_pct);
                        } else {
                            $('#dis_persen').removeClass('is-invalid');
                            $('#errorDiskonPersenAdd').removeClass('invalid-feedback');
                            $('#errorDiskonPersenAdd').html('');
                        }

                        if (response.error.kode_barang) {
                            $('#kode_barang').addClass('is-invalid');
                            $('#errorKodeBarangAdd').addClass('invalid-feedback');
                            $('#errorKodeBarangAdd').html(response.error.kode_barang);
                        } else {
                            $('#kode_barang').removeClass('is-invalid');
                            $('#errorKodeBarangAdd').removeClass('invalid-feedback');
                            $('#errorKodeBarangAdd').html('');
                        }
                    } else {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses,
                        });

                        $('#modalSelectBarang').modal('hide');
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

    $('#kode_cust').change(function() {
        let cust_code = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('transaksi/get_data_cust'); ?>",
            data: {
                cust_code: cust_code
            },
            dataType: "JSON",
            success: function(data) {
                console.log(data.cust[0].name)
                $('#id_cust').val(data.cust[0].id);
                $('#nama_cust').val(data.cust[0].name);
                $('#telp_cust').val(data.cust[0].telp);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
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
                $('#id_barang').val(data.barang[0].id);
                $('#nama_barang').val(data.barang[0].nama);
                $('#harga_bandrol').val(data.barang[0].harga);

                let harga_bandrol = parseInt($('#harga_bandrol').val());

                let diskon_persen = parseInt($('#dis_persen').val());
                let total_discon_nilai = harga_bandrol * diskon_persen / 100;
                let total_harga_diskon = harga_bandrol - total_discon_nilai;

                let diskon_nilai = $('#dis_nilai').val(total_discon_nilai)
                let harga_diskon = $('#harga_diskon').val(total_harga_diskon)

                let harga_total = parseInt($('#harga_diskon').val()) * parseInt($('#qty').val());
                $('#harga_total').val(harga_total);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })

    $(document).ready(function() {
        $('#dis_persen').keyup(function() {
            let diskon_persen = parseInt($('#dis_persen').val());
            let harga_bandrol = parseInt($('#harga_bandrol').val());

            let total_discon_nilai = harga_bandrol * diskon_persen / 100;
            let total_harga_diskon = harga_bandrol - total_discon_nilai;

            let diskon_nilai = $('#dis_nilai').val(total_discon_nilai)
            let harga_diskon = $('#harga_diskon').val(total_harga_diskon)

            let harga_total = parseInt($('#harga_diskon').val()) * parseInt($('#qty').val());
            $('#harga_total').val(harga_total);
        })

        $('#qty').keyup(function() {
            let quantity = parseInt($('#qty').val());
            let harga_diskon = parseInt($('#harga_diskon').val());

            let harga_total = harga_diskon * quantity;
            $('#harga_total').val(harga_total);
        })
    });
</script>



<?php $this->endSection(); ?>