<?php
session_start();
if(isset($_SESSION['status'])){
	header("location:admin");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistem Informasi Penjualan</title>

    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/iziToast/iziToast.min.css">

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/iziToast/iziToast.min.js"></script>

    <style type="text/css">
    	@import url('https://fonts.googleapis.com/css2?family=Belanosima&display=swap');
    	.cover{
    		height: 100vh;
    	}
    	.in-cover{
    		font-family: 'Belanosima', sans-serif;
    		min-width: 35%;
    	}
    </style>
</head>
<body class="bg-light">

	<div class="cover w-100 d-flex align-items-center justify-content-center">
	    <div class="bg-white border border-dark rounded py-md-4 px-md-5 px-4 py-3 in-cover">
	    	<h1>Login</h1>
	    	<hr class="my-1 border border-dark">
		    <div id="error-message" class="alert alert-danger my-0" style="display: none;"></div>
		    <form>
		    	<div class="form-group">
			        <label for="username">Username:</label><br>
			        <input type="text" id="username" name="username" class="form-control border border-dark">
			    </div>
			    <div class="form-group">
			        <label for="password">Password:</label><br>
			        <input type="password" id="password" name="password" class="form-control border border-dark">
			    </div>

		        <input type="submit" value="Login" class="mt-2 btn btn-primary w-100">
		    </form>
		</div>
	</div>
    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                var username = $('#username').val();
                var password = $('#password').val();

                if (username == "" || password == "") {
                	$('#error-message').text('Lengkapi username dan password login anda.').show();
                	return false;
            	} else {
	                $.ajax({
	                    url: 'api/login.php',
	                    method: 'POST',
	                    data: { username: username, password: password },
	                    dataType: 'json',
	                    success: function(response) {
	                        if (response.code === 200) {
	                            window.location.href = 'admin';
	                        } else {
	                            $('#error-message').text(response.message).show();
	                        }
	                    },
	                    error: function(xhr) {
	                        console.log(xhr)
	                        $('#error-message').text('Terjadi kesalahan. Silakan coba lagi.').show();
	                    }
	                });
	            }
            });
        });
    </script>
</body>
</html>
