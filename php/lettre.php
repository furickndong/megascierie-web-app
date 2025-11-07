<?php
include('config.php');

// Si un client est sélectionné
$lettre = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_facture = $_POST['id_facture'];

    // Récupérer les infos de la facture et du client
    $sql = "SELECT f.id_facture, f.date_facture, f.montant_total, 
                   c.nom_client, c.adresse_client, c.email_client
            FROM FACTURE f
            JOIN CLIENT c ON f.id_client = c.id_client
            WHERE f.id_facture = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_facture]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $lettre = "
        <div class='lettre'>
          <h2>Lettre à {$data['nom_client']}</h2>
          <p><strong>Date :</strong> " . date('d/m/Y') . "</p>
          <p><strong>Objet :</strong> Livraison de produits débités</p>
          <p>Chère/Cher {$data['nom_client']},</p>
          <p>Nous avons le plaisir de vous informer que votre commande
             (facture n°{$data['id_facture']}) d’un montant total de 
             <strong>{$data['montant_total']} FCFA</strong> est prête à être livrée.</p>
          <p>Adresse de livraison : {$data['adresse_client']}</p>
          <p>Merci de votre confiance.</p>
          <p>Cordialement,<br><strong>MegaScierie</strong></p>
        </div>";
    } else {
        $lettre = "<p style='color:red;'>Facture introuvable.</p>";
    }
}

// Charger la liste des factures disponibles
$factures = $conn->query("SELECT id_facture FROM FACTURE")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Génération de lettres | MegaScierie</title>
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
  max-width: 600px;
  margin: auto;
}
h1 {
  text-align: center;
  color: #006d3b;
  margin-bottom: 20px;
}
select, button {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  margin-top: 10px;
}
button {
  background: #006d3b;
  color: white;
  border: none;
  font-weight: 600;
  transition: 0.3s;
}
button:hover {
  background: #00a86b;
}
.lettre {
  background: #f8fdf9;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  margin-top: 20px;
}
</style>
</head>
<body>

<div class="container">
  <h1>📨 Génération de lettre</h1>
  <form method="POST">
    <label for="id_facture">Choisir une facture :</label>
    <select name="id_facture" id="id_facture" required>
      <option value="">-- Sélectionner --</option>
      <?php foreach ($factures as $f): ?>
        <option value="<?= $f['id_facture'] ?>">Facture n°<?= $f['id_facture'] ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Générer la lettre</button>
  </form>

  <?= $lettre ?>
</div>

</body>
</html>
