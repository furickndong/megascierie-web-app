<?php
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Annexe 2 - Destination Produits',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,8,"Date de génération : ".date('d/m/Y H:i')."\n\nCe rapport récapitule les destinations des produits débités, clients et volumes livrés.");
$pdf->Ln(10);
$pdf->Cell(0,10,"Chef de production : ___________________",0,1);
$pdf->Output('D', 'Annexe2_Destination_Produits.pdf');
?>
