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
      
  ?>
    <div class="container-scroller">
      
      <?php include 'template/header.php' ?>
      
      <div class="container-fluid page-body-wrapper">
        
        <?php include 'template/sidebar.php' ?>  
        
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-6">
                <h2>Data Transaksi</h2>
              </div>
              <div class="col-md-6 text-right">
                <a href="tambah-transaksi.php" id="storebarang" class="btn btn-success py-2 px-3"><i class="fas fa-plus-square p-1" ></i>Tambah Transaksi</a>
              </div>
            </div>
            <hr>
            <table id="datatable" class="table table-bordered table-hovered table-striped">
              <thead class="bg-dark text-white">
                <tr>
                  <th>No</th>
                  <th>Nomor Invoice</th>
                  <th>Tanggal Transaksi</th>
                  <th>Total Transaksi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-light"></tbody>
            </table>
          </div>
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023.  Sistem Informasi Penjualan - <i>Point of Sale</i></span>
            </div>
          </footer>
        </div>
      </div>
    </div>
<div class="modal fade" id="addBarang" tabindex="-1" role="dialog" aria-labelledby="addBarangLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- Konten Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="addBarangLabel">Tambah data transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addtransaksi" style="margin-top: -5%">
          <label class="mt-2" for="tanggal">Tanggal Transaksi:</label>
          <input type="date" id="tanggal" name="tanggal" class="form-control border border-dark">

          <?php

            include '../koneksi.php';
            $querymax = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MIN(idbarang) FROM barang"));
            echo "<input id='minid' name='minid' type='hidden' value='".($querymax['MIN(idbarang)'])."'/>";

          ?>
              <label class="mt-2" for="nmbarang">Nama Barang:</label>
              <select id="store_transaksi_idbarang" class="form-control border text-dark" name="store_transaksi_idbarang">
                <?php
                  
                  $data = mysqli_query($koneksi,"SELECT * FROM barang");
                  while ($row = mysqli_fetch_assoc($data)) {
                    echo "<option value='".$row['idbarang']."'>".$row['nmbarang']."</option>";
                  }
                ?>
              </select>

              <label class="mt-2" for="kuantitas">Kuantitas:</label>
              <input type="number" id="kuantitas" name="kuantitas" class="form-control border border-dark">

              <label class="mt-2" for="transaksi_total">Harga Barang:</label>
              <div class="input-group">
                <div class="input-group-append border-top border-bottom border-left border-dark">
                  <span class="input-group-text text-dark">Rp</span>
                </div>
                <input type="number" id="transaksi_total" name="transaksi_total" class="form-control border border-dark" readonly>
              </div>

              <label class="mt-2" for="kuantitas">Total Harga:</label>
              <div class="input-group">
                <div class="input-group-append border-top border-bottom border-left border-dark">
                  <span class="input-group-text text-dark">Rp</span>
                </div>
                <input type="number" id="totalHarga" name="totalHarga" class="form-control border border-dark" readonly>
              </div>
              <br>
            <input type="submit" value="Simpan" class="mt-2 form-control bg-primary text-white w-100">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editBarang" tabindex="-1" role="dialog" aria-labelledby="editBarangLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- Konten Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="editBarangLabel">Update data barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="upstok" style="margin-top: -5%">
              <label class="mt-2" for="nmbarang">Nama Barang:</label>
              <input type="hidden" id="idbarang" name="idbarang" class="form-control border border-dark">
              <input type="text" id="nmbarang" name="nmbarang" class="form-control border border-dark">

              <label class="mt-2" for="harga">Harga Barang:</label>
              <div class="input-group">
                <div class="input-group-append border-top border-bottom border-left border-dark">
                  <span class="input-group-text text-dark">Rp</span>
                </div>
                <input type="number" id="harga" name="harga" class="form-control border border-dark">
              </div>

              <label class="mt-2" for="stok">Stok:</label>
              <input type="number" id="stok" name="stok" class="form-control border border-dark">
              <br>
            <input type="submit" value="Simpan" class="mt-2 form-control bg-primary text-white w-100">
        </form>
      </div>
    </div>
  </div>
</div>

    

  <?php } ?>
  <script type="text/javascript">
    function formatRupiah(angka) {
      var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      });
      return formatter.format(angka);
    }

    document.getElementsByClassName('nav-item')[3].classList.add('active')
    $(document).ready(function() {
      $.ajax({
        url: '../api/invoice.php?function=all',
        dataType: 'json',
        success: function(data) {
          $.each(data.data, function(index, item) {
            $('#datatable').find('tbody').append(
              '<tr>' +
              '<td width="10%"><h5>'+(index+1)+'</h5></td>' +
              '<td><h5>' + item.no_invoice + '</h5></td>' +
              '<td><h5>' + item.tgl_transaksi + '</h5></td>' +
              '<td><h5>' + formatRupiah(item.total_transaksi) + '</h5></td>' +
              '<td width="20%">'+
              '<a href="invoice-struk.php?invoice='+item.no_invoice+'" target="__blank" class="print btn btn-info ml-2 py-3 pl-3 pr-3"><i class="fas fa-print"></i></a>'+
              '<button id="'+item.no_invoice+'" class="hapus btn btn-danger ml-2 py-3 pl-3 pr-3"><i class="fas fa-trash"></i></button>'+
              '</td>' +
              '</tr>'
            );
          });
          $('#datatable').dataTable();
        },
        error: function(xhr) {
          console.log(xhr)
        }
      });
    });
    $(document).on('click', '.hapus', function(){
      var id = $(this).attr('id')
      iziToast.question({
        title : 'Konfirmasi',
        message: 'Ingin menghapus data ?',
        position: 'topCenter',
        buttons: [
          ['<button><b>YES</b></button>', function (instance, toast) {
            $.ajax({
              url: '../api/invoice.php?function=delete',
              type: 'POST',
              data: { id: id },
              success: function(response) {
                if(response.code == 200){
                  iziToast.success({
                    title : 'Berhasil menghapus data',
                    position: 'topCenter',
                    onClosing: function() {
                      location.reload(true)
                    }
                  })
                } else {
                  alert('data gagal dihapus')
                }
              },
              error: function(xhr, status, error) {
                console.error(error);
              }
            });
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }, true],
          ['<button>NO</button>', function (instance, toast) {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ],
      })
    })
  </script>
</body>

</html>

