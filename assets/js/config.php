<?php

  $server = 'localhost';
  $user = 'root';
  $pass = '';
  $dbname = 'umkm';
  
  $conn = mysqli_connect($server, $user, $pass, $dbname);
  $base_url = 'http://localhost/umkm/';
  if (!$conn) {
    die('error'.mysqli_error());
  }

?>