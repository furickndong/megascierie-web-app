<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "megascierie-web");
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $numero = $_POST['numero'] ?? '';
  $essence = $_POST['essence'] ?? '';
  $volume = $_POST['volume'] ?? 0;
  $origine = $_POST['origine'] ?? '';
  $date_entree = $_POST['date_entree'] ?? '';
  $longueur = $_POST['longueur'] ?? 0;
  $diametre = $_POST['diametre'] ?? 0;
  $qualite = $_POST['qualite'] ?? '';
  $statut = $_POST['statut'] ?? '';

  if (
    $numero && $essence && $volume > 0 &&
    $origine && $date_entree && $longueur > 0 &&
    $diametre > 0 && $qualite && $statut
  ) {
    // Vérifier si le numéro existe déjà
    $check = $conn->prepare("SELECT id_grume FROM grume WHERE numero = ?");
    $check->bind_param("s", $numero);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
      $stmt = $conn->prepare(
        "INSERT INTO grume (numero, essence, volume, origine, date_entree, longueur, diametre, qualite, statut)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
      );
      $stmt->bind_param(
        "ssdssdsss",
        $numero, $essence, $volume, $origine, $date_entree, $longueur, $diametre, $qualite, $statut
      );
      $stmt->execute();
      $stmt->close();
      echo "<p style='color:green;'>✅ Grume enregistrée avec succès !</p>";
    } else {
      echo "<p style='color:red;'>❌ Ce numéro de grume existe déjà.</p>";
    }
    $check->close();
  } else {
    echo "<p style='color:red;'>❌ Tous les champs obligatoires doivent être remplis.</p>";
  }
}

// Récupération des grumes
$grumes = $conn->query("SELECT * FROM grume ORDER BY date_entree DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>MegaScierie | Saisie de grume</title>
</head>
<body>
<section class="main">
  <header>
    <h1>🌲 Saisie de grume</h1>
    <p class="user">👤 Administrateur</p>
  </header>

  <div class="form-section">
    <h2>Nouvelle grume</h2>
    <form method="POST" action="">
      <div>
        <label>Numéro de grume</label>
        <input type="text" name="numero" placeholder="Ex: GRM-001" required>
      </div>
      <div>
        <label>Essence</label>
        <select name="essence" required>
          <option value="">-- Choisir --</option>
          <option>Okoumé</option>
          <option>Azobé</option>
          <option>Padouk</option>
          <option>Ozigo</option>
        </select>
      </div>
      <div>
        <label>Volume (m³)</label>
        <input type="number" name="volume" step="0.01" placeholder="Ex: 3.45" required>
      </div>
      <div>
        <label>Origine</label>
        <input type="text" name="origine" placeholder="Ex: Camp 2 - Oyem" required>
      </div>
      <div>
        <label>Date d'entrée</label>
        <input type="date" name="date_entree" required>
      </div>
      <div>
        <label>Longueur (m)</label>
        <input type="number" name="longueur" step="0.01" placeholder="Ex: 5.70" required>
      </div>
      <div>
        <label>Diamètre (cm)</label>
        <input type="number" name="diametre" step="0.1" placeholder="Ex: 38.5" required>
      </div>
      <div>
        <label>Qualité</label>
        <select name="qualite" required>
          <option value="">-- Choisir --</option>
          <option>1ère</option>
          <option>2ème</option>
          <option>3ème</option>
          <option>Standard</option>
          <option>Hors catégorie</option>
        </select>
      </div>
      <div>
        <label>Statut</label>
        <select name="statut" required>
          <option value="">-- Choisir --</option>
          <option>En stock</option>
          <option>Transformée</option>
          <option>Exportée</option>
          <option>Déclassée</option>
        </select>
      </div>
      <button type="submit">✅ Enregistrer la grume</button>
    </form>
  </div>

  <div class="table-section">
    <h2>📋 Liste des grumes</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Numéro</th>
          <th>Essence</th>
          <th>Volume (m³)</th>
          <th>Origine</th>
          <th>Date entrée</th>
          <th>Longueur</th>
          <th>Diamètre</th>
          <th>Qualité</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $grumes->fetch_assoc()) { ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['numero']) ?></td>
            <td><?= htmlspecialchars($row['essence']) ?></td>
            <td><?= number_format($row['volume'], 2) ?></td>
            <td><?= htmlspecialchars($row['origine']) ?></td>
            <td><?= date("d/m/Y", strtotime($row['date_entree'])) ?></td>
            <td><?= number_format($row['longueur'], 2) ?></td>
            <td><?= number_format($row['diametre'], 1) ?></td>
            <td><?= htmlspecialchars($row['qualite']) ?></td>
            <td><?= htmlspecialchars($row['statut']) ?></td>
            <td class="actions">
              <button>✏️</button>
              <button>🗑️</button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</section>
</body>
</html>
