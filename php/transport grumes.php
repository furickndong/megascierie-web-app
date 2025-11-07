<?php
// Connexion à la base
$conn = new mysqli("localhost", "root", "", "megascierie-web");
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

// Insertion du transport
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $numero_transport = $_POST['numero_transport'] ?? '';
  $chauffeur = $_POST['chauffeur'] ?? '';
  $immatriculation = $_POST['immatriculation'] ?? '';
  $point_depart = $_POST['point_depart'] ?? '';
  $destination = $_POST['destination'] ?? '';
  $date_depart = $_POST['date_depart'] ?? '';
  $date_arrivee = $_POST['date_arrivee'] ?? '';
  $statut = $_POST['statut'] ?? 'en cours';

  if ($numero_transport && $chauffeur && $immatriculation && $point_depart && $destination && $date_depart) {
    $stmt = $conn->prepare("INSERT INTO transport (numero_transport, chauffeur, immatriculation, point_depart, destination, date_depart, date_arrivee, statut) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $numero_transport, $chauffeur, $immatriculation, $point_depart, $destination, $date_depart, $date_arrivee, $statut);
    $stmt->execute();
    $stmt->close();
  }
}

// Lecture des données
$result = $conn->query("SELECT * FROM transport ORDER BY date_depart DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MegaScierie | Transport de grumes</title>
  
</head>
<body>

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <h2 class="logo">🪵 MegaScierie</h2>
    <ul>
      <li><a href="dashboard.php">🏠 Tableau de bord</a></li>
      <li><a href="saisie_grumes.php">🌲 Saisie de grumes</a></li>
      <li class="active">🚚 Transport de grumes</li>
      <li><a href="production.php">🪚 Production</a></li>
      <li><a href="stocks.php">📦 Stocks</a></li>
      <li><a href="facturation.php">💰 Facturation</a></li>
      <li><a href="rapports.php">📄 Rapports</a></li>
      <li><a href="parametres.php">⚙️ Paramètres</a></li>
    </ul>
  </aside>

  <!-- ===== MAIN ===== -->
  <section class="main">
    <header>
      <h1>🚚 Transport de grumes</h1>
      <p class="user">👤 Administrateur</p>
    </header>

    <!-- ===== FORMULAIRE ===== -->
    <div class="form-section">
      <h2>Nouvel envoi de grumes</h2>
      <form method="POST" action="">
        <div>
          <label>Numéro du transport</label>
          <input type="text" name="numero_transport" placeholder="Ex: TRG-001" required>
        </div>
        <div>
          <label>Chauffeur</label>
          <input type="text" name="chauffeur" placeholder="Nom du chauffeur" required>
        </div>
        <div>
          <label>Camion / Immatriculation</label>
          <input type="text" name="immatriculation" placeholder="Ex: TG-4589" required>
        </div>
        <div>
          <label>Point de départ</label>
          <input type="text" name="point_depart" placeholder="Ex: Camp 3 - Makokou" required>
        </div>
        <div>
          <label>Destination</label>
          <input type="text" name="destination" placeholder="Ex: Scierie Libreville" required>
        </div>
        <div>
          <label>Date de départ</label>
          <input type="date" name="date_depart" required>
        </div>
        <div>
          <label>Date d’arrivée</label>
          <input type="date" name="date_arrivee">
        </div>
        <div>
          <label>Statut</label>
          <select name="statut">
            <option value="en cours">En cours</option>
            <option value="livré">Livré</option>
            <option value="annulé">Annulé</option>
          </select>
        </div>
        <button type="submit">✅ Enregistrer le transport</button>
      </form>
    </div>

    <!-- ===== TABLE ===== -->
    <div class="table-section">
      <h2>📋 Liste des transports</h2>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Numéro</th>
            <th>Chauffeur</th>
            <th>Camion</th>
            <th>Départ</th>
            <th>Destination</th>
            <th>Date départ</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$i}</td>
                      <td>{$row['numero_transport']}</td>
                      <td>{$row['chauffeur']}</td>
                      <td>{$row['immatriculation']}</td>
                      <td>{$row['point_depart']}</td>
                      <td>{$row['destination']}</td>
                      <td>{$row['date_depart']}</td>
                      <td>{$row['statut']}</td>
                      <td class='actions'>
                        <button>✏️</button>
                        <button>🗑️</button>
                      </td>
                    </tr>";
              $i++;
            }
          } else {
            echo "<tr><td colspan='9' style='text-align:center;color:#999;'>Aucun transport enregistré.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>
</body>
</html>
