<!-- ISI POS -->
<div class="modal fade" id="modalKomik" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">DATA PRODUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabel Buku -->
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Sampul</th>
                            <th width="30%">Judul</th>
                            <th width="15%">Tahun Terbit</th>
                            <th width="15%">Harga</th>
                            <th width="10%">Stok</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($komik as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <img src="img/<?= $value['cover'] ?>" alt="" width="100">
                                </td>
                                <td><?= $value['title'] ?></td>
                                <td><?= $value['release_year'] ?></td>
                                <td><?= $value['price'] ?></td>
                                <td><?= $value['stock'] ?></td>
                                <td>
                                    <button onclick="add_cart('<?= $value['komik_id'] ?>','<?= $value['title'] ?>','<?= $value['price'] ?>','<?= $value['discount'] ?>')" class="btn btn-success"><i class="fa fa-cart-plus"></i>Tambahkan</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- END Tabel Buku -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END ISI POS -->
<script>
    function add_cart(id, name, price, discount) {
        $.ajax({
            url: "<?= base_url('beli') ?>",
            method: "POST",
            data: {
                id: id,
                name: name,
                qty: 1,
                price: price,
                discount: discount,
            },
            success: function(data) {
                load()
            }
        });
    }
</script>