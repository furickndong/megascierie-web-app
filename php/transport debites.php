<?php
// ================================
// 🔌 Connexion à la base de données
// ================================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "megascierie-web"; // ✅ Mets ici le nom exact de ta base

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base : " . $conn->connect_error);
}

// =====================================
// 💾 Insertion d’un transport de débités
// =====================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_transport = $_POST["numero_transport"];
    $date_transport = $_POST["date_transport"];
    $chauffeur = $_POST["chauffeur"];
    $immatriculation = $_POST["immatriculation"];
    $point_depart = $_POST["point_depart"];
    $destination = $_POST["destination"];
    $type_produit = $_POST["type_produit"];
    $volume_transporte = $_POST["volume_transporte"];
    $date_depart = $_POST["date_depart"];
    $date_arrivee = $_POST["date_arrivee"];
    $statut = $_POST["statut"];

    $sql = "INSERT INTO transport (
                numero_transport, 
                date_transport, 
                chauffeur, 
                immatriculation, 
                point_depart, 
                destination, 
                type_produit, 
                volume_transporte, 
                date_depart, 
                date_arrivee, 
                statut
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssss",
        $numero_transport,
        $date_transport,
        $chauffeur,
        $immatriculation,
        $point_depart,
        $destination,
        $type_produit,
        $volume_transporte,
        $date_depart,
        $date_arrivee,
        $statut
    );

    if ($stmt->execute()) {
        echo "<script>alert('✅ Transport enregistré avec succès !');</script>";
    } else {
        echo "<script>alert('❌ Erreur lors de l’enregistrement : " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// ==========================================
// 📋 Récupération des transports depuis la DB
// ==========================================
$sql_select = "SELECT * FROM transport ORDER BY id_transport DESC";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Transport de débités</title>
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background: #f5f7f6;
      margin: 0;
      padding: 30px;
    }
    h1 {
      color: #064420;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }
    th {
      background: #e3fcec;
      color: #064420;
    }
    tr:hover {
      background: #f9fdfb;
    }
    a.btn {
      display: inline-block;
      margin-top: 20px;
      background: #0b6b36;
      color: white;
      padding: 10px 18px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
    }
    a.btn:hover {
      background: #098b4a;
    }
  </style>
</head>
<body>

  <h1>🚛 Liste des transports de débités</h1>
  <a class="btn" href="transport_debite.html">➕ Ajouter un transport</a>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Numéro</th>
        <th>Date</th>
        <th>Produit</th>
        <th>Volume (m³)</th>
        <th>Départ</th>
        <th>Destination</th>
        <th>Chauffeur</th>
        <th>Immatriculation</th>
        <th>Départ</th>
        <th>Arrivée</th>
        <th>Statut</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id_transport']}</td>
                      <td>{$row['numero_transport']}</td>
                      <td>{$row['date_transport']}</td>
                      <td>{$row['type_produit']}</td>
                      <td>{$row['volume_transporte']}</td>
                      <td>{$row['point_depart']}</td>
                      <td>{$row['destination']}</td>
                      <td>{$row['chauffeur']}</td>
                      <td>{$row['immatriculation']}</td>
                      <td>{$row['date_depart']}</td>
                      <td>{$row['date_arrivee']}</td>
                      <td>{$row['statut']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='12' style='text-align:center;'>Aucun transport enregistré</td></tr>";
      }
      ?>
    </tbody>
  </table>

</body>
</html>

<?php
$conn->close();
?>
