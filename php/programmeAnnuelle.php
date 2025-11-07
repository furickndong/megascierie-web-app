<?php
// --- Connexion à la base de données ---
$conn = new mysqli("localhost", "root", "", "megascie3");
if ($conn->connect_error) {
  die("<tr><td colspan='6'>❌ Erreur de connexion : " . $conn->connect_error . "</td></tr>");
}

// --- Requête pour récupérer les données ---
$sql = "SELECT p.annee, 
               p.mois, 
               p.type_produit, 
               p.volume_prevu, 
               u.nom AS responsable, 
               p.statut
        FROM PROGRAMMEANNUEL p
        LEFT JOIN UTILISATEUR u ON p.responsable_programme = u.id_utilisateur
        ORDER BY p.annee DESC, p.mois ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['annee']}</td>
            <td>{$row['mois']}</td>
            <td>{$row['type_produit']}</td>
            <td>{$row['volume_prevu']}</td>
            <td>{$row['responsable']}</td>
            <td>{$row['statut']}</td>
          </tr>";
  }
} else {
  echo "<tr><td colspan='6' class='no-data'>Aucun programme enregistré</td></tr>";
}

$conn->close();
?>
