<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="/">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">TRANSAKSI</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    Penjualan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url('jual') ?>">Transaksi</a>
                        <a class="nav-link" href="<?= base_url('jual/laporan') ?>">Laporan</a>
                    </nav>
                </div>
                <!-- Pembelian -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    Pembelian
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url('beli') ?>">Transaksi</a>
                        <a class="nav-link" href="<?= base_url('beli/laporan') ?>">Laporan</a>
                    </nav>
                </div>
                <?php if (session()->role == "Karyawan" || session()->role == "Owner" || session()->role == "Manajer" || session()->role == "Admin") : ?>
                    <a class="nav-link" href="/book">
                        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                        Data Buku
                    </a>
                    <a class="nav-link" href="/komik">
                        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                        Data Buku Komik
                    </a>
                <?php endif; ?>
                <?php if (session()->role == "Manajer" || session()->role == "Owner" || session()->role == "Admin") : ?>
                    <a class="nav-link" href="/customer">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Data Customer
                    </a>
                <?php endif; ?>
                <?php if (session()->role == "Owner" || session()->role == "Manajer") : ?>
                    <a class="nav-link" href="/supplier">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Data Supplier
                    </a>
                <?php endif; ?>
                <a class="nav-link" href="/mahasiswa">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Data Mahasiswa
                </a>
                <?php if (session()->role == "Owner") : ?>
                    <a class="nav-link" href="/users">
                        <div class="sb-nav-link-icon"><i class="fas fa-users fa-fw"></i></div>
                        Data User
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as : <?= session()->user_name ?></div>
            Start Bootstrap
        </div>
    </nav>
</div>