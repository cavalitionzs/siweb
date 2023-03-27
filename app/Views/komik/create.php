<?= $this->extend('layout/template') ?>
<?= $this->section('tugas') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?= strtoupper($title) ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Komik</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                List <?= $title ?>
            </div>
            <div>
                <div class="card-body">
                    <!--ISI-->
                    <form action="<?= base_url('/komik/create') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3 row">
                            <label for="title" class="col-sm-2 col-form-label">Judul</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= old('title') ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('title') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="author" class="col-sm-2 col-form-label">Penulis</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="author" name="author">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="release_year" class="col-sm-2 col-form-label">Tahun Terbit</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control <?= $validation->hasError('release_year') ? 'is-invalid' : '' ?>" id="release_year" name="release_year">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('release_year') ?>
                                </div>
                            </div>
                            <label for="stock" class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control <?= $validation->hasError('stock') ? 'is-invalid' : '' ?>" id="stock" name="stock">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('stock') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="price" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control <?= $validation->hasError('price') ? 'is-invalid' : '' ?>" id="price" name="price">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('price') ?>
                                </div>
                            </div>
                            <label for="discount" class="col-sm-2 col-form-label">Diskon</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="discount" name="discount">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="komik_category_id" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-3">
                                <select type="text" class="form-control" id="komik_category_id" name="komik_category_id">
                                    <?php foreach ($category as $value) : ?>
                                        <option value="<?= $value['komik_category_id'] ?>">
                                            <?= $value['name_category'] ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary me-md-2" type="submit">Simpan</button>
                            <button class=" btn btn-danger" type="reset">Batal</button>
                        </div>
                    </form>
                    <!--ISI-->
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>