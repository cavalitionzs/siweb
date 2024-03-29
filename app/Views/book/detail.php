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
                Liset Detail <?= $title ?>
            </div>
            <div class="card-body">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= base_url('img/' . $data_book['cover']) ?>" alt="" width="100%">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $data_book['title'] ?></h5>
                                <p class="card-text">Penulis : <?= $data_book['author'] ?></p>
                                <p class="card-text">Tahun Rilis : <?= $data_book['release_year'] ?></p>
                                <p class="card-text">Harga : <?= $data_book['price'] ?></p>
                                <p class="card-text">Stok : <?= $data_book['stock'] ?></p>
                                <p class="card-text">Kategori : <?= $data_book['name_category'] ?></p>
                                <div class="d-grip gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="<?= base_url('book') ?>">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>