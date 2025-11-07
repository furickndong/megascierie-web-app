<?php
include('config.php');

$mois = date('m');
$annee = date('Y');

$sql_debite = "SELECT COUNT(*) AS nb, SUM(volume) AS total_volume FROM PRODUITDEBITE WHERE MONTH(date_debit)=? AND YEAR(date_debit)=?";
$stmt1 = $conn->prepare($sql_debite);
$stmt1->execute([$mois, $annee]);
$debite = $stmt1->fetch(PDO::FETCH_ASSOC);

$sql_facture = "SELECT COUNT(*) AS nb, SUM(montant_total) AS total_montant FROM FACTURE WHERE MONTH(date_facture)=? AND YEAR(date_facture)=?";
$stmt2 = $conn->prepare($sql_facture);
$stmt2->execute([$mois, $annee]);
$facture = $stmt2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Rapport mensuel | MegaScierie</title>
<style>
body {
  font-family: Poppins, sans-serif;
  background: #f5f8f6;
  padding: 30px;
}
.container {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 0 8px rgba(0,0,0,0.1);
  max-width: 700px;
  margin: auto;
}
h1 {
  text-align: center;
  color: #006d3b;
  margin-bottom: 20px;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
}
th {
  background: #006d3b;
  color: white;
}
</style>
</head>
<body>

<div class="container">
  <h1>📅 Rapport du mois <?= "$mois / $annee" ?></h1>

  <table>
    <tr><th>Indicateur</th><th>Valeur</th></tr>
    <tr><td>Total produits débités</td><td><?= $debite['nb'] ?></td></tr>
    <tr><td>Volume total débité</td><td><?= $debite['total_volume'] ?> m³</td></tr>
    <tr><td>Factures émises</td><td><?= $facture['nb'] ?></td></tr>
    <tr><td>Montant total facturé</td><td><?= number_format($facture['total_montant'], 0, ',', ' ') ?> FCFA</td></tr>
  </table>
</div>

</body>
</html>
