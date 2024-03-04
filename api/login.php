<?php
    include '../koneksi.php';
    session_start();

    $username = $_POST['username'];
    $password = md5($_POST['password']);;

    $data = mysqli_query($koneksi,"SELECT * FROM admin WHERE username='".$username."' AND password='".$password."'");
    $cek = mysqli_num_rows($data);
    $result = mysqli_fetch_assoc($data);
    if($cek > 0){
        $_SESSION['userid'] = $result['id'];
        $_SESSION['status'] = 'login';
        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Login successful'
        ];
    }else{
        $response = [
            'code' => 422,
            'status' => 'error',
            'message' => 'Username atau password salah'
        ];
    }
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);

?>