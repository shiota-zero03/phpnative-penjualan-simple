<?php
session_start();
if(!isset($_SESSION['status'])){
    header("Location: ../");
}
require('../third-party/fpdf/fpdf.php');
include '../koneksi.php';
if(isset($_GET['invoice'])){
    $userdata = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE id = '".$_SESSION['userid']."'"));
    $data = mysqli_query($koneksi,"SELECT * FROM transaksi WHERE invoice = '".$_GET['invoice']."'");
    $cek = mysqli_query($koneksi,"SELECT * FROM invoice WHERE no_invoice = '".$_GET['invoice']."'");
    $inv = mysqli_fetch_assoc($cek);

    if(mysqli_num_rows($cek) > 0){

        $pdf = new FPDF();
        $pdf->AddPage('P', array(115, 145));
        $pdf->SetFont('Courier', 'B', 20);
        $pdf->Cell(0, 10, 'My Invoice', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Line(5, $pdf->GetY(), 110, $pdf->GetY());
        $pdf->Ln(1);
        $pdf->Line(5, $pdf->GetY(), 110, $pdf->GetY());

        $pdf->Ln(3);
        $pdf->SetFont('Courier', 'B', 10);
        $pdf->Cell(30, 5, 'Admin', 0);
        $pdf->Cell(10, 5, ':', 0);
        $pdf->Cell(60, 5, $userdata['nama'], 0, 1);
        $pdf->Cell(30, 5, 'No. Invoice', 0);
        $pdf->Cell(10, 5, ':', 0);
        $pdf->Cell(60, 5, $userdata['nama'], 0, 1);
        $pdf->Cell(30, 5, 'Alamat', 0);
        $pdf->Cell(10, 5, ':', 0);
        $pdf->Cell(60, 5, 'Jakarta - Indonesia', 0, 1);

        $pdf->Ln(3);
        $pdf->Line(5, $pdf->GetY(), 110, $pdf->GetY());
        $pdf->Ln(1);
        $pdf->Line(5, $pdf->GetY(), 110, $pdf->GetY());

        while ($item = mysqli_fetch_assoc($data)) {
            $itemName = $item['transaksi_nmbarang'];
            $itemTotal = $item['transaksi_total'];
            $itemQuantity = $item['transaksi_qty'];
            $itemQ = $itemTotal/$itemQuantity;

            $pdf->SetFont('Courier', 'B', 15);
            $pdf->Cell(60, 10, $itemName, 0, 1);
            $pdf->SetFont('Courier', 'B', 10);
            $pdf->Cell(75, 5, $itemQuantity.' X '.number_format($itemQ, 0, ',', '.'), 0);
            $pdf->Cell(35, 5, number_format($itemTotal, 0, ',', '.'), 0, 1);
        }
        $pdf->Ln(5);
        $pdf->Line(5, $pdf->GetY(), 110, $pdf->GetY());
        $pdf->Ln(1);
        $pdf->Line(5, $pdf->GetY(), 110, $pdf->GetY());

        $pdf->SetFont('Courier', 'B', 15);
        $pdf->Cell(25, 10, 'Total', 0);
        $pdf->Cell(50, 10, 'Rp', 0);
        $pdf->Cell(35, 10, number_format($inv['total_transaksi'], 0, ',', '.'), 0, 1);

        $pdf->Ln(1);
        $pdf->Line(5, $pdf->GetY(), 110, $pdf->GetY());
        $pdf->Ln(1);
        $pdf->Line(5, $pdf->GetY(), 110, $pdf->GetY());
        $pdf->Ln(1);

        $pdf->SetFont('Courier', 'I', 12);
        $pdf->Cell(100, 5, date('Y-m-d H:i:s'), 0, 1, 'C');

        $pdf->Output();
    } else {
        header("Location: transaksi.php");    
    }
} else {
    header("Location: transaksi.php");
}

?>
