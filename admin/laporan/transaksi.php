<?php

	$data = mysqli_query($koneksi,"SELECT * FROM transaksi JOIN invoice on transaksi.invoice = invoice.no_invoice");
    $counqty = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(transaksi.transaksi_qty) AS quantity FROM transaksi JOIN invoice on transaksi.invoice = invoice.no_invoice"));
    $countrans = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(transaksi.transaksi_total) AS totaltransaksi FROM transaksi JOIN invoice on transaksi.invoice = invoice.no_invoice"));

	$pdf = new FPDF();
    $pdf->AddPage('L', array(297, 210));
    $pdf->SetFont('Times', 'B', 20);
    $pdf->Cell(0, 10, 'Data Transaksi', 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Line(5, $pdf->GetY(), 292, $pdf->GetY());
    $pdf->Ln(1);
    $pdf->Line(5, $pdf->GetY(), 292, $pdf->GetY());

    $pdf->Ln(3);
    
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(49.4, 10, 'No. Invoice', 1, 0, 'C');
    $pdf->Cell(49.4, 10, 'Tanggal Transaksi', 1, 0, 'C');
    $pdf->Cell(49.4, 10, 'Nama Barang', 1, 0, 'C');
    $pdf->Cell(49.4, 10, '@', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Qty', 1, 0, 'C');
    $pdf->Cell(49.4, 10, 'Total', 1, 1, 'C');

    $no = 1;

    while ($item = mysqli_fetch_assoc($data)) {
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(49.4, 10, $item['no_invoice'], 1, 0, 'C');
        $pdf->Cell(49.4, 10, date('l, d-Y', strtotime($item['tgl_transaksi'])), 1, 0, 'C');
        $pdf->Cell(49.4, 10, $item['transaksi_nmbarang'], 1, 0, 'C');
        $pdf->Cell(49.4, 10, 'Rp '.number_format($item['transaksi_total']/$item['transaksi_qty'], '2', ',','.'), 1, 0, 'C');
        $pdf->Cell(20, 10, $item['transaksi_qty'], 1, 0, 'C');
        $pdf->Cell(49.4, 10, 'Rp '.number_format($item['transaksi_total'], '2', ',','.'), 1, 1, 'C');
    }

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(207.6, 10, 'Total', 1, 0, 'C');
    $pdf->Cell(20, 10, $counqty['quantity'], 1, 0, 'C');
    $pdf->Cell(49.4, 10, 'Rp '.number_format($countrans['totaltransaksi'], '2', ',','.'), 1, 1, 'C');

    $pdf->Output();

?>