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
                <h2>Daftar Barang</h2>
              </div>
              <div class="col-md-6 text-right">
                <button id="storebarang" class="btn btn-success py-2 px-3"><i class="fas fa-plus-square p-1" ></i>Tambah Data</button>
              </div>
            </div>
            <hr>
            <table id="datatable" class="table table-bordered table-hovered table-striped">
              <thead class="bg-dark text-white">
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Harga Barang</th>
                  <th>Stok</th>
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
        <h5 class="modal-title" id="addBarangLabel">Tambah data barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addstok" style="margin-top: -5%">
              <label class="mt-2" for="nmbarang">Nama Barang:</label>
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
    document.getElementsByClassName('nav-item')[2].classList.add('active')
    $(document).ready(function() {
      $.ajax({
        url: '../api/barang.php?function=all',
        dataType: 'json',
        success: function(data) {
          $.each(data.data, function(index, item) {
            $('#datatable').find('tbody').append(
              '<tr>' +
              '<td width="10%"><h5>'+(index+1)+'</h5></td>' +
              '<td><h5>' + item.nmbarang + '</h5></td>' +
              '<td><h5>' + item.harga + '</h5></td>' +
              '<td><h5>' + item.stok + '</h5></td>' +
              '<td width="20%">'+
              '<button id="'+item.idbarang+'" class="edit btn btn-primary py-3 pl-3 pr-3"><i class="fas fa-edit"></i></button>'+
              '<button id="'+item.idbarang+'" class="hapus btn btn-danger ml-2 py-3 pl-3 pr-3"><i class="fas fa-trash"></i></button>'+
              '</td>' +
              '</tr>'
            );
          });
          $('#datatable').dataTable();
        },
        error: function(xhr) {
          console.log(xhr)
          alert('Terjadi kesalahan. Silakan coba lagi.')
        }
      });
      $('#storebarang').click(function(){
        $('#addBarang').modal('show')
      })
      $('form#addstok').submit(function(e) {
          e.preventDefault();
          var nama = $('#nmbarang').val();
          var harga = $('#harga').val();
          var stok = $('#stok').val();

          if (nama == "" || harga == "" || stok == "") {
            iziToast.error({
              title : 'Data belum lengkap',
              position: 'topCenter',
            })
            return false;
          } else {
              $.ajax({
                  url: '../api/barang.php?function=store',
                  method: 'POST',
                  data: { nama: nama, harga: harga, stok: stok },
                  success: function(response) {
                      if (response.code === 200) {
                          iziToast.success({
                            title : 'Berhasil menambahkan data',
                            position: 'topCenter',
                            onClosing: function() {
                              location.reload(true)
                            }
                          })
                      } else {
                        alert('ggal')
                          $('#error-message').text(response.message).show();
                      }
                  },
                  error: function(xhr) {
                      console.log(xhr)
                      alert('Terjadi kesalahan. Silakan coba lagi.')
                  }
              });
          }
      });
      $('form#upstok').submit(function(e) {
          e.preventDefault();
          var id = $('form#upstok').find('input[name=idbarang]').val();
          var nama = $('form#upstok').find('input[name=nmbarang]').val();
          var harga = $('form#upstok').find('input[name=harga]').val();
          var stok = $('form#upstok').find('input[name=stok]').val();

          if (nama == "" || harga == "" || stok == "") {
            iziToast.error({
              title : 'Data belum lengkap',
              position: 'topCenter',
            })
            return false;
          } else {
              $.ajax({
                  url: '../api/barang.php?function=update',
                  method: 'POST',
                  data: { id: id, nama: nama, harga: harga, stok: stok },
                  success: function(response) {
                      if (response.code === 200) {
                          iziToast.success({
                            title : 'Berhasil mengupdate data',
                            position: 'topCenter',
                            onClosing: function() {
                              location.reload(true)
                            }
                          })
                      } else {
                        alert('ggal')
                          $('#error-message').text(response.message).show();
                      }
                  },
                  error: function(xhr) {
                      console.log(xhr)
                      alert('Terjadi kesalahan. Silakan coba lagi.')
                  }
              });
          }
      });
    });
    $(document).on('click', '.edit', function(){
      var id = $(this).attr('id')
      $.ajax({
        url: '../api/barang.php?function=show',
        type: 'POST',
        data: { id: id },
        success: function(response) {
          if(response.code == 200){
            $('form#upstok').find('input[name=idbarang]').val(response.data.idbarang)
            $('form#upstok').find('input[name=nmbarang]').val(response.data.nmbarang)
            $('form#upstok').find('input[name=harga]').val(response.data.harga)
            $('form#upstok').find('input[name=stok]').val(response.data.stok)
            $('#editBarang').modal('show')
          } else {
            alert('data gagal ditampilkan')
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    })
    $(document).on('click', '.hapus', function(){
      var id = $(this).attr('id')
      iziToast.question({
        title : 'Konfirmasi',
        message: 'Ingin menghapus data ?',
        position: 'topCenter',
        buttons: [
          ['<button><b>YES</b></button>', function (instance, toast) {
            $.ajax({
              url: '../api/barang.php?function=delete',
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

