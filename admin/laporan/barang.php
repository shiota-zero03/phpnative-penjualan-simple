<?php

	$data = mysqli_query($koneksi,"SELECT * FROM barang");

	$pdf = new FPDF();
    $pdf->AddPage('P', array(210, 297));
    $pdf->SetFont('Times', 'B', 20);
    $pdf->Cell(0, 10, 'Data Barang', 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());
    $pdf->Ln(1);
    $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());

    $pdf->Ln(3);
    
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(60, 10, 'Nama Barang', 1, 0, 'C');
    $pdf->Cell(60, 10, 'Harga Barang', 1, 0, 'C');
    $pdf->Cell(60, 10, 'Stok', 1, 1, 'C');

    $no = 1;

    while ($item = mysqli_fetch_assoc($data)) {
	    $pdf->SetFont('Times', '', 12);
	    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
	    $pdf->Cell(60, 10, $item['nmbarang'], 1, 0, 'C');
	    $pdf->Cell(60, 10, 'Rp '.number_format($item['harga'], '2', ',','.'), 1, 0, 'C');
	    $pdf->Cell(60, 10, $item['stok'], 1, 1, 'C');
    }

    $pdf->Output();

?>