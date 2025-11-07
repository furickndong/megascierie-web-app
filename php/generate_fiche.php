<?php
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Fiche Technique - MegaScierie',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,8,"Date de génération : ".date('d/m/Y H:i')."\n\nCette fiche technique regroupe les informations liées aux grumes, bois débités et capacités de production mensuelles.");
$pdf->Ln(10);
$pdf->Cell(0,10,"Responsable de la production : ___________________",0,1);
$pdf->Output('D', 'Fiche_Technique.pdf');
?>
