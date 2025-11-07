<?php
// Ce script crée un fichier ZIP contenant les 3 rapports PDF précédents.
require('fpdf/fpdf.php');
$files = [
  'Fiche_Technique.pdf' => 'Fiche Technique - MegaScierie',
  'Annexe4_Approvisionnement.pdf' => 'Annexe 4 - Approvisionnement',
  'Annexe2_Destination_Produits.pdf' => 'Annexe 2 - Destination Produits'
];

foreach ($files as $filename => $title) {
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',16);
  $pdf->Cell(0,10,$title,0,1,'C');
  $pdf->Ln(10);
  $pdf->SetFont('Arial','',12);
  $pdf->MultiCell(0,8,"Rapport exporté le ".date('d/m/Y H:i'));
  $pdf->Output('F', $filename);
}

$zip = new ZipArchive();
$zipFile = 'Rapports_MegaScierie.zip';
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
  foreach (array_keys($files) as $file) $zip->addFile($file);
  $zip->close();
}

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="'.$zipFile.'"');
readfile($zipFile);

foreach (array_keys($files) as $file) unlink($file);
unlink($zipFile);
?>
