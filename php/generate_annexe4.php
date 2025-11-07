<?php
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Annexe 4 - Approvisionnement',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,8,"Date de génération : ".date('d/m/Y H:i')."\n\nCe rapport présente les données d’approvisionnement en grumes, fournisseurs et quantités reçues sur la période.");
$pdf->Ln(10);
$pdf->Cell(0,10,"Chef d’approvisionnement : ___________________",0,1);
$pdf->Output('D', 'Annexe4_Approvisionnement.pdf');
?>
