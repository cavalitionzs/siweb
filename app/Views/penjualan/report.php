<?= $this->extend('layout/template') ?>
<?= $this->section('tugas') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?= strtoupper($title) ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Transaksi Penjualan</li>
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
                <!-- FILTER -->
                <form action="<?= base_url('jual/laporan/filter') ?>" method="post">
                    <div class="container">
                        <div class="row">
                            <div class="col-4">
                                <input type="date" class="form-control" name="tgl_awal" value="<?= $tanggal['tgl_awal'] ?>" title="Tanggal Awal">
                            </div>
                            <div class="col-4">
                                <input type="date" class="form-control" name="tgl_akhir" value="<?= $tanggal['tgl_akhir'] ?>" title="Tanggal Akhir">
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary">Filter</button>
                            </div>
                            <div>
                                <a target="_blank" class="btn btn-primary mb-3" type="button" href="<?= base_url('jual/exportpdf') ?>">EXPORT PDF</a>
                                <a target="_blank" class="btn btn-primary mb-3" type="button" href="<?= base_url('jual/exportexcel') ?>">EXPORT EXCEL</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- SELESAI FILTER -->
                <!-- ISI REPORT -->
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Tanggal Transaksi</th>
                            <th>User</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($result as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['sale_id'] ?></td>
                                <td><?= date("d/m/Y H:i:s", strtotime($value['tgl_transaksi'])) ?></td>
                                <td><?= $value['firstname'] ?> <?= $value['lastname'] ?></td>
                                <td><?= $value['name_cust'] ?></td>
                                <td><?= number_to_currency($value['total'], 'IDR', 'id_ID', 2) ?></td>
                                <td><a target="_blank" class="btn btn-danger mb-3" type="button" href="<?= base_url('jual/invoicepdf') ?>/<?= $value['sale_id'] ?>">Detail</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- SELESAI ISI REPORT -->
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>