<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'template/metadata-link-script.php' ?>
  
</head>
<body>
  <?php 
    session_start();
    include '../koneksi.php';

    if(!isset($_SESSION['status'])){
      echo "<script>
        iziToast.error({
              title : 'Tidak dapat memuat halaman',
              message: 'Silahkan login terlebih dahulu',
              position: 'topCenter',
              onClosing: function() {
                window.location.href = '../';
              }
          })
      </script>";
    } else {
      $userdata = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE id = '".$_SESSION['userid']."'"));
      $banyaktransaksi = mysqli_query($koneksi, "SELECT * FROM invoice WHERE tgl_transaksi = '".date('Y-m-d')."'");
      $barangs = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
      $users = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM admin"));

      $banyaktrans = 0;
      $totaltrans = 0;
      while($trans = mysqli_fetch_assoc($banyaktransaksi)){
        $totaltransaksi = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE invoice = '".$trans['no_invoice']."'");

        $banyaktrans += (int)$trans['total_transaksi'];
        $totaltrans += mysqli_num_rows($totaltransaksi);
      }
  ?>
    <div class="container-scroller">
      
      <?php include 'template/header.php' ?>
      
      <div class="container-fluid page-body-wrapper">
        
        <?php include 'template/sidebar.php' ?>  
        
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome <?= $userdata['nama'] ?></h3>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg">
                  <div class="card-people mt-auto">
                    <img src="assets/images/dashboard/people.svg" alt="people">
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin transparent">
                <div class="row">
                  <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                      <div class="card-body">
                        <p class="mb-4">Total Transaksi Hari Ini</p>
                        <h3 class="mb-2"><?= $totaltrans ?></h3>
                        <hr class="mt-2 mb-3 border border-white">
                        <div class="w-100 bg-white py-1 text-center rounded mb-0">
                          <a class="text-dark text-center w-100 text-decoration-none my-0" href="transaksi.php">Lihat selengkapnya </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                      <div class="card-body">
                        <p class="mb-4">Pemasukan Hari Ini</p>
                        <h3 class="mb-2">Rp<?= number_format($banyaktrans, 0, ',', '.') ?></h3>
                        <hr class="mt-2 mb-3 border border-white">
                        <div class="w-100 bg-white py-1 text-center rounded mb-0">
                          <a class="text-dark text-center w-100 text-decoration-none my-0" href="transaksi.php">Lihat selengkapnya </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                      <div class="card-body">
                        <p class="mb-4">Total Barang</p>
                        <h3 class="mb-2"><?= $barangs ?></h3>
                        <hr class="mt-2 mb-3 border border-white">
                        <div class="w-100 bg-white py-1 text-center rounded mb-0">
                          <a class="text-dark text-center w-100 text-decoration-none my-0" href="barang.php">Lihat selengkapnya </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 stretch-card transparent">
                    <div class="card card-light-danger">
                      <div class="card-body">
                        <p class="mb-4">Banyak Pengguna</p>
                        <h3 class="mb-2"><?= $users ?></h3>
                        <hr class="mt-2 mb-3 border border-white">
                        <div class="w-100 bg-white py-1 text-center rounded mb-0">
                          <a class="text-dark text-center w-100 text-decoration-none my-0" href="pengguna.php">Lihat selengkapnya </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023.  Sistem Informasi Penjualan - <i>Point of Sale</i></span>
            </div>
          </footer>
        </div>
      </div>
    </div>

    

  <?php } ?>
  <script type="text/javascript">
    document.getElementsByClassName('nav-item')[1].classList.add('active')
  </script>
</body>

</html>

