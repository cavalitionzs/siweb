<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="/">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="/book">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Data Buku
                </a>
                <a class="nav-link" href="/komik">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Data Buku Komik
                </a>
                <a class="nav-link" href="/customer">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Data Customer
                </a>
                <a class="nav-link" href="/supplier">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Data Supplier
                </a>
                <a class="nav-link" href="/mahasiswa">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Data Mahasiswa
                </a>
                <?php if (session()->role == "Admin" || session()->role == "Owner") : ?>
                    <a class="nav-link" href="/users">
                        <div class="sb-nav-link-icon"><i class="fas fa-users fa-fw"></i></div>
                        Data User
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>