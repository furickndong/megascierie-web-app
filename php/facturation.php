<?php
$conn = new mysqli("localhost", "root", "", "megascierie-web");
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

// Requête pour récupérer les factures
$sql = "SELECT numero_facture, date_facture, montant_total, TVA, remise, mode_paiement, statut FROM FACTURE";
$result = $conn->query($sql);

// Vérification et affichage
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['numero_facture']."</td>";
    echo "<td>".$row['date_facture']."</td>";
    echo "<td>".$row['montant_total']." FCFA</td>";
    echo "<td>".$row['TVA']."%</td>";
    echo "<td>".$row['remise']."%</td>";
    echo "<td>".$row['mode_paiement']."</td>";
    echo "<td>".$row['statut']."</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='7' style='text-align:center;color:gray;'>Aucune facture trouvée</td></tr>";
}

$conn->close();
?>

