<?php

	session_start();
	if(!isset($_SESSION['status'])){
	    header("Location: ../../");
	}
	require('../../third-party/fpdf/fpdf.php');
	include '../../koneksi.php';
	if(isset($_GET['laporan'])){
		if($_GET['laporan'] == 'barang'){
			include 'barang.php';
		} elseif($_GET['laporan'] == 'transaksi'){
			include 'transaksi.php';
		}
	} else {
    	header("Location: ../");
	}

?>