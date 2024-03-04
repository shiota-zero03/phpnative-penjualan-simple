<!DOCTYPE html>
<html>
<head>
	<title>Sistem Informasi Penjualan</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../assets/iziToast/iziToast.min.css">
    <script type="text/javascript" src="../assets/iziToast/iziToast.min.js"></script>

</head>
<body>
	<?php 
		session_start();
		session_destroy();
		echo "<script>
			iziToast.success({
	        	title : 'Berhasil logout',
	        	position: 'topCenter',
	        	onClosing: function() {
	        		window.location.href = '../';
	        	}
	    	})
		</script>";
	?>
</body>
</html>