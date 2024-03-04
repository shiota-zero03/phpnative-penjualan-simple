<?php

	include '../koneksi.php';
	if(isset($_GET['function'])){
		if ($_GET['function'] == 'all') {

			$data = mysqli_query($koneksi,"SELECT * FROM barang");
	    	while ($row = mysqli_fetch_assoc($data)) {
    			$result[] = $row;
			}


	        $response = [
	            'code' => 200,
	            'status' => 'success',
	            'data' => $result,
	            'message' => 'Data ditemukan'
	        ];
		    header('Content-Type: application/json');
		    http_response_code(200);
		    echo json_encode($response);

		} elseif ($_GET['function'] == 'store') {

			$nama = $_POST['nama'];
			$harga = $_POST['harga'];
			$stok = $_POST['stok'];

			mysqli_query($koneksi,"INSERT INTO barang (idbarang, nmbarang, harga, stok) VALUES (NULL, '".$nama."', '".$harga."', '".$stok."');");

			$response = [
	            'code' => 200,
	            'status' => 'success',
	            'message' => 'Data berhasil ditambahkan'
	        ];
		    header('Content-Type: application/json');
		    http_response_code(200);
		    echo json_encode($response);

		} elseif ($_GET['function'] == 'show') {

			$id = $_POST['id'];
			$data = mysqli_query($koneksi,"SELECT * FROM barang WHERE idbarang = '".$id."'");
	    	$result = mysqli_fetch_assoc($data);


	        $response = [
	            'code' => 200,
	            'status' => 'success',
	            'data' => $result,
	            'message' => 'Data ditemukan'
	        ];
		    header('Content-Type: application/json');
		    http_response_code(200);
		    echo json_encode($response);

		} elseif ($_GET['function'] == 'update') {

			$id = $_POST['id'];
			$nama = $_POST['nama'];
			$harga = $_POST['harga'];
			$stok = $_POST['stok'];

			mysqli_query($koneksi,"UPDATE barang SET nmbarang = '".$nama."', harga = '".$harga."', stok = '".$stok."' WHERE idbarang = '".$id."'");

			$response = [
	            'code' => 200,
	            'status' => 'success',
	            'message' => 'Data berhasil diupdate'
	        ];
		    header('Content-Type: application/json');
		    http_response_code(200);
		    echo json_encode($response);

		} elseif ($_GET['function'] == 'delete') {

			mysqli_query($koneksi,"DELETE FROM barang WHERE idbarang='".$_POST['id']."'");

	        $response = [
	            'code' => 200,
	            'status' => 'success',
	            'message' => 'Data berhasil dihapus'
	        ];
		    header('Content-Type: application/json');
		    http_response_code(200);
		    echo json_encode($response);

		}
	} else {
		$response = [];
		header('Content-Type: application/json');
	    http_response_code(404);
	    echo json_encode($response);
	}
?>