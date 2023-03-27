<?= $this->extend('layout/template') ?>
<?= $this->section('tugas') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?= strtoupper($title) ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Buku</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                List <?= $title ?>
            </div>
            <div>
                <div class="card-body">
                    <!--ISI-->
                    <h5 class="card-title"><?= $data_book['title'] ?></h5>
                    <div class="col-md-4">
                        <img src="<?= base_url('img/' . $data_book['cover']) ?>" alt="" width="50%">
                    </div>
                    <p class="card-text">Penulis:<br><?= $data_book['author'] ?></p>
                    <p class="card-text">Tahun Rilis: <?= $data_book['release_year'] ?></p>
                    <p class="card-text">Harga: <?= $data_book['price'] ?></p>
                    <p class="card-text">Stok: <?= $data_book['stock'] ?></p>
                    <p class="card-text">Kategori: <?= $data_book['name_category'] ?></p>
                    <div class="d-grip gap-2 d-md-block">
                        <a class="btn btn-dark" type="button" href="<?= base_url('book') ?>">Kembali</a>
                    </div>
                    <!--ISI-->
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>