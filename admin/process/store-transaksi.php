<?php
	
	include '../../koneksi.php';

	$idbarang = $_POST['store_transaksi_idbarang'];
	$invoice = $_POST['invoice'];
	$kuantitas = $_POST['kuantitas'];
	$totalHarga = $_POST['totalHarga'];

	$res = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang WHERE idbarang = '".$idbarang."'"));
	
	$namabarang = $res['nmbarang'];

	$cek = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE invoice = '".$invoice."' AND transaksi_idbarang = '".$idbarang."'");
	if(mysqli_num_rows($cek) > 0){
		$use = mysqli_fetch_assoc($cek);
		$totalbarangbefore = $use['transaksi_total'];
		$qtybefore = $use['transaksi_qty'];

		$harganow = $totalbarangbefore + $totalHarga;
		$totalnow = $qtybefore + $kuantitas;

		$store = mysqli_query($koneksi, "UPDATE transaksi SET transaksi_total = '".$harganow."', transaksi_qty = '".$totalnow."'");
	} else {
		$store = mysqli_query($koneksi, "INSERT INTO transaksi (invoice, transaksi_total, transaksi_qty, transaksi_idbarang, transaksi_nmbarang) VALUES ('".$invoice."', '".$totalHarga."', '".$kuantitas."', '".$idbarang."', '".$namabarang."')");
	}

	$stok = $res['stok'];
	$minusqty = $stok - $kuantitas;

	$update = mysqli_query($koneksi,"UPDATE barang SET stok = '".$minusqty."' WHERE idbarang = '".$idbarang."'");
	
	if($store && $update){
		header("Location: " . $_SERVER['HTTP_REFERER']);
  		exit();
	}

?>