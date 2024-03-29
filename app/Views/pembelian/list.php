<?= $this->extend('layout/template') ?>
<?= $this->section('tugas') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?= strtoupper($title) ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Transaksi Pembeliam</li>
        </ol>
        <!--START FLASH DATA-->
        <!-- < ?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-success" role="alert">
                < ?= session()->getFlashdata('msg') ?>
            </div>
        < ?php endif; ?> -->
        <!--END FLASH DATA-->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                List <?= $title ?>
            </div>
            <div class="card-body">
                <!-- ISI POS -->
                <div class="row">
                    <div class="col">
                        <label class="col-form-label">Tanggal</label>
                        <input type="text" value="<?= date('d/m/Y') ?>" disabled>
                    </div>
                    <div class="col">
                        <label class="col-form-label">User</label>
                        <input type="text" value="<?= session()->user_name ?>" disabled>
                    </div>
                    <div class="col">
                        <label class="col-form-label">Supplier: </label>
                        <input type="text" id="nama-supp" disabled>
                        <input type="hidden" id="id-supp">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" data-bs-target="#modalKomik" data-bs-toggle="modal">Pilih Produk</button>
                        <button class="btn btn-dark" data-bs-target="#modalSupp" data-bs-toggle="modal">Cari Supplier</button>
                    </div>
                </div>
                <table class="table table-striped table-hover mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="detail_cart"></tbody>
                </table>

                <div class="container">
                    <div class="row">
                        <div class="col-8">
                            <label class="col-form-label">Total Bayar</label>
                            <h1><span id="spanTotal">0</span></h1>
                        </div>
                        <div class="col-4">
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label">Nominal</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="nominal" autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label">Kembalian</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="kembalian" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                        <button onclick="bayar()" class="btn btn-success me-md-2" type="button">Proses Bayar</button>
                        <button onclick="location.reload()" class="btn btn-primary" type="button">Transaksi Baru</button>
                    </div>
                </div>
                <!-- END ISI POS -->
            </div>
        </div>
    </div>
</main>
<?= $this->include('pembelian/modal-komik') ?>
<?= $this->include('pembelian/modal-supplier') ?>
<script>
    function load() {
        $('#detail_cart').load("<?= base_url('beli/load') ?>");
        $('#spanTotal').load("<?= base_url('beli/gettotal') ?>");
    }

    $(document).ready(function() {
        load();
    });

    // Ubah Jumlah Item
    $(document).on('click', '.ubah_cart', function() {
        var row_id = $(this).attr("id");
        var qty = $(this).attr("qty");
        $('#rowid').val(row_id);
        $('#qty').val(qty);
        $('#modalUbah').modal('show');
    });

    // Hapus Item Cart
    $(document).on('click', '.hapus_cart', function() {
        var row_id = $(this).attr("id");
        $.ajax({
            url: "<?= base_url('beli') ?>/" + row_id,
            method: "DELETE",
            success: function(data) {
                load();
            }
        });
    });

    // Pembayaran
    function bayar() {
        var nominal = $('#nominal').val();
        var idsupp = $('#id-supp').val();
        $.ajax({
            url: "<?= base_url('beli/bayar') ?>",
            method: "POST",
            data: {
                'nominal': nominal,
                'id-supp': idsupp
            },
            success: function(response) {
                var result = JSON.parse(response);
                swal({
                    title: result.msg,
                    icon: result.status ? "success" : "error",
                });
                load();
                $('#nominal').val("");
                $('#kembalian').val(result.data.kembalian);
            }
        });
    }
</script>
<?= $this->endSection() ?>