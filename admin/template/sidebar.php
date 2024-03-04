<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link " href="dashboard.php">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="barang.php">
        <i class="icon-layout menu-icon"></i>
        <span class="menu-title">Barang</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="transaksi.php">
        <i class="icon-bar-graph menu-icon"></i>
        <span class="menu-title">Transaksi</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Unduh Laporan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="laporan/index.php?laporan=barang" target="__blank">Laporan Barang</a></li>
          <li class="nav-item"> <a class="nav-link" href="laporan/index.php?laporan=transaksi" target="__blank">Laporan Transaksi</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="pengguna.php">
        <i class="ti-user menu-icon"></i>
        <span class="menu-title">Pengguna</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link bg-danger text-white" href="logout.php">
        <i class="ti-power-off menu-icon text-white"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
  </ul>
</nav>