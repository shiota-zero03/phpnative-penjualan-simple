<?php

  include '../koneksi.php';

?>
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
      $queryinv= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MAX(no_invoice) as numb FROM invoice"));
      $inv = substr($queryinv['numb'], 4, 8);
      if(!$inv){
        $invoice = 'INV-10000001';
      } else {
        $invnow = $inv+1;
        $invoice = 'INV-'.$invnow;
      }
      
  ?>
    <div class="container-scroller">
      
      <?php include 'template/header.php' ?>
      
      <div class="container-fluid page-body-wrapper">
        
        <?php include 'template/sidebar.php' ?>  
        
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-6">
                <h2><?= $invoice ?></h2>
              </div>
              <div class="col-md-6 text-right">
                <form action="process/store-invoice.php" method="post">
                  <input type="hidden" name="invoice" value="<?= $invoice ?>">
                  <button type="button" id="storebarang" class="btn btn-success py-2 px-3"><i class="fas fa-plus-square p-1" ></i>Tambah Transaksi</button>
                  <button type="submit" id="storebarang" class="btn btn-primary ml-2 py-2 px-3"><i class="fas fa-check-square p-1" ></i>Simpan</button>
                </form>
              </div>
            </div>
            <hr>
            <table id="datatable" class="table table-bordered table-hovered table-striped">
              <thead class="bg-dark text-white">
                <tr>
                  <th>no</th>
                  <th>Nama Barang</th>
                  <th>Kuantitas</th>
                  <th>Harga Total</th>
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
        <form id="addtransaksi" style="margin-top: -5%" action="process/store-transaksi.php" method="post">
          <label class="mt-2" for="invoice">Nomor Invoice:</label>
          <input type="text" readonly="" value="<?= $invoice ?>" id="invoice" name="invoice" class="form-control border border-dark">

          <?php

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
              <input required="" type="number" value="1" id="kuantitas" name="kuantitas" class="form-control border border-dark">

              <label class="mt-2" for="transaksi_total">Harga Barang:</label>
              <div class="input-group">
                <div class="input-group-append border-top border-bottom border-left border-dark">
                  <span class="input-group-text text-dark">Rp</span>
                </div>
                <input type="number" id="transaksi_total" name="transaksi_total" class="form-control border border-dark" readonly>
              </div>

              <label class="mt-2" for="totalHarga">Total Harga:</label>
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
    function calculateTotalHarga() {
      var hargaBarang = parseInt($('#transaksi_total').val());
      var stokBarang = parseInt($('#kuantitas').val());
      var totalHarga = hargaBarang * stokBarang;

      $('#totalHarga').val(totalHarga);
    }

    document.getElementsByClassName('nav-item')[3].classList.add('active')
    $(document).ready(function() {
      var invoice = $('#invoice').val()
      $.ajax({
        url: '../api/transaksi.php?function=showinvoice',
        type: 'POST',
        data: { invoice: invoice },
        dataType: 'json',
        success: function(data) {
          $.each(data.data, function(index, item) {
            $('#datatable').find('tbody').append(
              '<tr>' +
              '<td width="10%"><h5>'+(index+1)+'</h5></td>' +
              '<td><h5>' + item.transaksi_nmbarang + '</h5></td>' +
              '<td><h5>' + item.transaksi_qty + '</h5></td>' +
              '<td><h5>' + formatRupiah(item.transaksi_total) + '</h5></td>' +
              '<td width="20%">'+
              '<button id="'+item.transaksi_id+'" class="hapus btn btn-danger ml-2 py-3 pl-3 pr-3"><i class="fas fa-trash"></i></button>'+
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
      $('#storebarang').click(function(){
        var selectedValue = $('#minid').val();
        $.ajax({
          url: '../api/barang.php?function=show',
          type: 'POST',
          data: { id: selectedValue },
          success: function(response) {
            if(response.code == 200){
              $('form#addtransaksi').find('input[name=transaksi_total]').val(response.data.harga)
              $('form#addtransaksi').find('input[name=totalHarga]').val(response.data.harga)
              $('#addBarang').modal('show')
            } else {
              alert('data gagal ditampilkan')
            }
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      })
      $('#store_transaksi_idbarang').on('change', function(){
        var selectedValue = $(this).val();
        $.ajax({
          url: '../api/barang.php?function=show',
          type: 'POST',
          data: { id: selectedValue },
          success: function(response) {
            if(response.code == 200){
              $('form#addtransaksi').find('input[name=transaksi_total]').val(response.data.harga)
              calculateTotalHarga();
            } else {
              alert('data gagal ditampilkan')
            }
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      })
      $('#kuantitas').on('input', function() {
        calculateTotalHarga();
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
              url: '../api/transaksi.php?function=delete',
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

