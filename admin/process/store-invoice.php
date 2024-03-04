<?php
	
	include '../../koneksi.php';

	$invoice = $_POST['invoice'];

	$sum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(transaksi_total) AS total FROM transaksi WHERE invoice = '".$invoice."'"));

	$store = mysqli_query($koneksi, "INSERT INTO invoice (no_invoice, tgl_transaksi, total_transaksi, status_transaksi) VALUES ('".$invoice."', '".date('Y-m-d')."', '".$sum['total']."', 'Tersimpan')");
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../assets/iziToast/iziToast.min.css">
	<script type="text/javascript" src="../../assets/iziToast/iziToast.min.js"></script>
</head>
<body>
<?php
	if($store){
		echo "
		<script>
			iziToast.success({
	            title : 'Berhasil menambahkan transaksi',
	            position: 'topCenter',
	            onClosing: function() {
	              location.href = '../transaksi.php'
	            }
	        })
	    </script>
		";
	}

?>
</body>