<?php
// Connexion unique
$conn = new mysqli("localhost", "root", "", "megascierie-web");
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

// Enregistrement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $date_production = $_POST['date_production'] ?? '';
  $type_produit = $_POST['type_produit'] ?? '';
  $volume_total = $_POST['volume_total'] ?? 0;
  $rendement = $_POST['rendement'] ?? '';
  $operateur_responsable = $_POST['operateur_responsable'] ?? null;

  if ($date_production && $type_produit && $operateur_responsable) {
    $stmt = $conn->prepare("INSERT INTO PRODUCTIONSCIERIE (date_production, type_produit, volume_total, rendement, operateur_responsable) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $date_production, $type_produit, $volume_total, $rendement, $operateur_responsable);
    $stmt->execute();
    $stmt->close();
  }
}

// Récupération des productions
$productions = $conn->query("
  SELECT p.*, u.nom, u.prenom 
  FROM PRODUCTIONSCIERIE p
  LEFT JOIN UTILISATEUR u ON p.operateur_responsable = u.id_utilisateur
  ORDER BY p.date_production DESC
");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="production_scierie.css">
</head>
<body>

<div class="table-section">
  <h2>📋 Historique des productions</h2>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Date</th>
        <th>Type produit</th>
        <th>Volume (m³)</th>
        <th>Rendement</th>
        <th>Opérateur</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $i = 1;
      while ($row = $productions->fetch_assoc()) {
        echo "<tr>
                <td>{$i}</td>
                <td>" . date('d/m/Y', strtotime($row['date_production'])) . "</td>
                <td>" . htmlspecialchars($row['type_produit']) . "</td>
                <td>" . number_format($row['volume_total'], 2) . "</td>
                <td>" . htmlspecialchars($row['rendement']) . "</td>
                <td>" . htmlspecialchars($row['nom'] . ' ' . $row['prenom']) . "</td>
              </tr>";
        $i++;
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>