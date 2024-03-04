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
                <h2>Daftar Pengguna</h2>
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
                  <th>Nama</th>
                  <th>Username</th>
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
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- Konten Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="addUserLabel">Tambah Admin Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="adduser" style="margin-top: -5%">
              <label class="mt-2" for="nama">Nama:</label>
              <input type="text" id="nama" name="nama" class="form-control border border-dark">

              <label class="mt-2" for="username">Username:</label>
              <input type="text" id="username" name="username" class="form-control border border-dark">

              <label class="mt-2" for="password">Password:</label>
              <input type="password" id="password" name="password" class="form-control border border-dark">

              <br>
            <input type="submit" value="Simpan" class="mt-2 form-control bg-primary text-white w-100">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edituser" tabindex="-1" role="dialog" aria-labelledby="edituserLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- Konten Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="edituserLabel">Update data barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="upuser" style="margin-top: -5%">
              <label class="mt-2" for="nama">Nama Barang:</label>
              <input type="hidden" id="id" name="id" class="form-control border border-dark">
              <input type="text" id="nama" name="nama" class="form-control border border-dark">

              <label class="mt-2" for="username">username:</label>
              <input type="text" id="username" name="username" class="form-control border border-dark">

              <label class="mt-2" for="password">Password:</label>
              <input type="password" id="password" name="password" class="form-control border border-dark">
              <br>
            <input type="submit" value="Simpan" class="mt-2 form-control bg-primary text-white w-100">
        </form>
      </div>
    </div>
  </div>
</div>

    

  <?php } ?>
  <script type="text/javascript">
    document.getElementsByClassName('nav-item')[5].classList.add('active')
    $(document).ready(function() {
      $.ajax({
        url: '../api/user.php?function=all',
        dataType: 'json',
        success: function(data) {
          $.each(data.data, function(index, item) {
            $('#datatable').find('tbody').append(
              '<tr>' +
              '<td width="10%"><h5>'+(index+1)+'</h5></td>' +
              '<td><h5>' + item.nama + '</h5></td>' +
              '<td><h5>' + item.username + '</h5></td>' +
              '<td width="20%">'+
              '<button id="'+item.id+'" class="edit btn btn-primary py-3 pl-3 pr-3"><i class="fas fa-edit"></i></button>'+
              '<button id="'+item.id+'" class="hapus btn btn-danger ml-2 py-3 pl-3 pr-3"><i class="fas fa-trash"></i></button>'+
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
        $('#addUser').modal('show')
      })
      $('form#adduser').submit(function(e) {
          e.preventDefault();
          var nama = $('#nama').val();
          var username = $('#username').val();
          var password = $('#password').val();

          if (nama == "" || username == "" || password == "") {
            iziToast.error({
              title : 'Data belum lengkap',
              position: 'topCenter',
            })
            return false;
          } else {
              $.ajax({
                  url: '../api/user.php?function=store',
                  method: 'POST',
                  data: { nama: nama, username: username, password: password },
                  success: function(response) {
                      if (response.code === 200) {
                          iziToast.success({
                            title : 'Berhasil menambahkan data',
                            position: 'topCenter',
                            onClosing: function() {
                              location.reload(true)
                            }
                          })
                      } else if(response.code === 422) {
                      	iziToast.error({
                            title : 'Username telah digunakan',
                            position: 'topCenter',
                          })
                      } else {
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
      $('form#upuser').submit(function(e) {
          e.preventDefault();
          var id = $('form#upuser').find('input[name=id]').val();
          var nama = $('form#upuser').find('input[name=nama]').val();
          var password = $('form#upuser').find('input[name=password]').val();
          var username = $('form#upuser').find('input[name=username]').val();

          if (nama == "" || password == "" || username == "") {
            iziToast.error({
              title : 'Data belum lengkap',
              position: 'topCenter',
            })
            return false;
          } else {
              $.ajax({
                  url: '../api/user.php?function=update',
                  method: 'POST',
                  data: { id: id, nama: nama, password: password, username: username },
                  success: function(response) {
                      if (response.code === 200) {
                          iziToast.success({
                            title : 'Berhasil mengupdate data',
                            position: 'topCenter',
                            onClosing: function() {
                              location.reload(true)
                            }
                          })
                      } else if(response.code === 422) {
                      	iziToast.error({
                            title : 'Username telah digunakan',
                            position: 'topCenter',
                          })
                      } else {
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
        url: '../api/user.php?function=show',
        type: 'POST',
        data: { id: id },
        success: function(response) {
          if(response.code == 200){
            $('form#upuser').find('input[name=id]').val(response.data.id)
            $('form#upuser').find('input[name=nama]').val(response.data.nama)
            $('form#upuser').find('input[name=password]').val(response.data.password)
            $('form#upuser').find('input[name=username]').val(response.data.username)
            $('#edituser').modal('show')
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
              url: '../api/user.php?function=delete',
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

