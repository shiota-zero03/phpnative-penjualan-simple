<?php

	include '../koneksi.php';
	if(isset($_GET['function'])){
		if ($_GET['function'] == 'all') {

			$data = mysqli_query($koneksi,"SELECT * FROM invoice");
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

			mysqli_query($koneksi,"DELETE FROM invoice WHERE no_invoice='".$_POST['id']."'");
			mysqli_query($koneksi,"DELETE FROM transaksi WHERE invoice ='".$_POST['id']."'");

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