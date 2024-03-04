<?php

	include '../koneksi.php';
	if(isset($_GET['function'])){
		if ($_GET['function'] == 'showinvoice') {

			$data = mysqli_query($koneksi,"SELECT * FROM transaksi WHERE invoice = '".$_POST['invoice']."'");
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

		} elseif ($_GET['function'] == 'delete') {

			$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM transaksi WHERE transaksi_id = '".$_POST['id']."'"));
			$res = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang WHERE idbarang = '".$data['transaksi_idbarang']."'"));

			$stok = $res['stok'];
			$kuantitas = $data['transaksi_qty'];
			
			$plusqty = $stok + $kuantitas;

			$update = mysqli_query($koneksi,"UPDATE barang SET stok = '".$plusqty."' WHERE idbarang = '".$data['transaksi_idbarang']."'");

			mysqli_query($koneksi,"DELETE FROM transaksi WHERE transaksi_id='".$_POST['id']."'");

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