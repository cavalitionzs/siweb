<?= $this->extend('layout/template') ?>
<?= $this->section('tugas') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?= strtoupper($title) ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Komik</li>
        </ol>
        <!--START FLASH DATA-->
        <?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>
        <!--END FLASH DATA-->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                List <?= $title ?>
            </div>
            <div class="card-body">
                <a class="btn btn-primary mb-3" type="button" href="<?= base_url('komik/create') ?>">
                    Tambah Buku Komik
                </a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stock</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_komik as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['title'] ?></td>
                                <td><?= $value['name_category'] ?></td>
                                <td><?= $value['price'] ?></td>
                                <td><?= $value['stock'] ?></td>
                                <td>
                                    <a href="komik-detail/<?= $value['slug'] ?>" class="btn btn-info text-white">
                                        <i class="fas fa-info-circle"></i>
                                        Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>