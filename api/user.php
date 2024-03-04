<?php

	include '../koneksi.php';
	if(isset($_GET['function'])){
		if ($_GET['function'] == 'all') {

			$data = mysqli_query($koneksi,"SELECT * FROM admin");
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
			$username = $_POST['username'];
			$password = md5($_POST['password']);

			$cekusername = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '".$username."'");
			if(mysqli_num_rows($cekusername) > 0){
				$response = [
		            'code' => 422,
		            'status' => 'error',
		            'message' => 'Username telah digunakan'
		        ];
			} else {
			mysqli_query($koneksi,"INSERT INTO admin (id, nama, username, password) VALUES (NULL, '".$nama."', '".$username."', '".$password."');");

				$response = [
		            'code' => 200,
		            'status' => 'success',
		            'message' => 'Data berhasil ditambahkan'
		        ];
			}
		    header('Content-Type: application/json');
		    http_response_code(200);
		    echo json_encode($response);

		} elseif ($_GET['function'] == 'show') {

			$id = $_POST['id'];
			$data = mysqli_query($koneksi,"SELECT * FROM admin WHERE id = '".$id."'");
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
			$username = $_POST['username'];
			$password = $_POST['password'];

			$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM admin WHERE id = '".$id."'"));

			if($data['password'] == $password){
				$pass = $password;
			} else {
				$pass = md5($password);
			}
			if($data['username'] != $username){
				$cekusername = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '".$username."'");
				if(mysqli_num_rows($cekusername) > 0){
					$response = [
			            'code' => 422,
			            'status' => 'success',
			            'message' => 'Data berhasil diupdate'
			        ];
			    } else {
			    	mysqli_query($koneksi,"UPDATE admin SET nama = '".$nama."', username = '".$username."', password = '".$pass."' WHERE id = '".$id."'");
			    	$response = [
			            'code' => 200,
			            'status' => 'success',
			            'message' => 'Data berhasil diupdate'
			        ];
			    }
			} else {
				mysqli_query($koneksi,"UPDATE admin SET nama = '".$nama."', username = '".$username."', password = '".$pass."' WHERE id = '".$id."'");
				$response = [
		            'code' => 200,
		            'status' => 'success',
		            'message' => 'Data berhasil diupdate'
		        ];
			}

		    header('Content-Type: application/json');
		    http_response_code(200);
		    echo json_encode($response);

		} elseif ($_GET['function'] == 'delete') {

			mysqli_query($koneksi,"DELETE FROM admin WHERE id='".$_POST['id']."'");

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