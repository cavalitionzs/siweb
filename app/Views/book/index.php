<?= $this->extend('layout/template') ?>
<?= $this->section('tugas') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?= strtoupper($title) ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Buku</li>
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
                <a class="btn btn-primary mb-3" type="button" href="<?= base_url('book/create') ?>">
                    Tambah Buku
                </a>
                <a class="btn btn-dark mb-3" type="button" data-bs-target="#modalImport" data-bs-toggle="modal">
                    Import Buku</a>
                <table id="datatablesSimple2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Cover</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stock</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_book as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="<?= base_url('img/' . $value['cover']) ?>" alt="" width="100"></td>
                                <td><?= $value['title'] ?></td>
                                <td><?= $value['name_category'] ?></td>
                                <td><?= $value['price'] ?></td>
                                <td><?= $value['stock'] ?></td>
                                <td>
                                    <a href="<?= base_url('book/book-detail/' . $value['slug']) ?>" class="btn btn-primary">
                                        <i class="fas fa-info-circle"></i>
                                        Detail</a>
                                    <a href="<?= base_url('book/edit/' . $value['slug']) ?>" class="btn btn-warning">
                                        <i class="fas fa-into-circle"></i>
                                        Ubah</a>
                                    <form action="<?= base_url('book/delete/' . $value['book_id']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" role="button" onclick="return confirm('Apakah anda yakin?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?= $this->include('book/modal') ?>
<?= $this->endSection() ?>