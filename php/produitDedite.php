<?php
include('connexion.php');
session_start();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $type = $_POST['type_produit'] ?? '';
  $volume = $_POST['volume'] ?? 0;
  $section = $_POST['section'] ?? '';
  $date_debit = $_POST['date_debit'] ?? '';
  $longueur = $_POST['longueur'] ?? 0;
  $destination = $_POST['destination'] ?? '';
  $qualite = $_POST['qualite'] ?? '';
  $id_grume = $_POST['id_grume_source'] ?? null;
  $id_production = $_POST['id_production'] ?? null;

  $stmt = $conn->prepare("INSERT INTO PRODUITDEBITE (type_produit, volume, section, date_debit, longueur, destination, qualite, id_grume_source, id_production) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sdssdssii", $type, $volume, $section, $date_debit, $longueur, $destination, $qualite, $id_grume, $id_production);
  $stmt->execute();
}

// Récupération des produits débités
$produits = $conn->query("SELECT * FROM PRODUITDEBITE ORDER BY date_debit DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>MegaScierie | Saisie produit débité</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <h1>🪵 Saisie d’un produit débité</h1>
    <form method="POST">
      <label>Type de produit</label>
      <input type="text" name="type_produit" required>

      <label>Volume (m³)</label>
      <input type="number" step="0.01" name="volume" required>

      <label>Section</label>
      <input type="text" name="section" required>

      <label>Date de débit</label>
      <input type="date" name="date_debit" required>

      <label>Longueur (m)</label>
      <input type="number" step="0.01" name="longueur" required>

      <label>Destination</label>
      <select name="destination" required>
        <option value="stock">Stock</option>
        <option value="client">Client</option>
        <option value="production">Production</option>
      </select>

      <label>Qualité</label>
      <input type="text" name="qualite">

      <label>ID grume source</label>
      <input type="number" name="id_grume_source">

      <label>ID production</label>
      <input type="number" name="id_production">

      <button type="submit">✅ Enregistrer le produit</button>
    </form>

    <h2>📋 Produits débités enregistrés</h2>
    <table>
      <thead>
        <tr>
          <th>#</th><th>Type</th><th>Volume</th><th>Section</th><th>Date</th><th>Longueur</th>
          <th>Destination</th><th>Qualité</th><th>Grume</th><th>Production</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $produits->fetch_assoc()) { ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['type_produit']) ?></td>
            <td><?= number_format($row['volume'], 2) ?></td>
            <td><?= htmlspecialchars($row['section']) ?></td>
            <td><?= $row['date_debit'] ?></td>
            <td><?= number_format($row['longueur'], 2) ?></td>
            <td><?= $row['destination'] ?></td>
            <td><?= htmlspecialchars($row['qualite']) ?></td>
            <td><?= $row['id_grume_source'] ?></td>
            <td><?= $row['id_production'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </main>
</body>
</html>