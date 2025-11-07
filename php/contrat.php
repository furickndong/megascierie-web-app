<?php
$conn = new mysqli("localhost", "root", "", "megascierie-web");
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $numeroContrat = $_POST['numero_contrat'] ?? '';
  $dateSignature = $_POST['date_signature'] ?? '';
  $duree = $_POST['duree'] ?? 0;
  $typeProduit = $_POST['type_produit'] ?? '';
  $quantitePrevue = $_POST['quantite_prevue'] ?? 0;
  $statut = $_POST['statut'] ?? 'actif';
  $conditionsParticulieres = $_POST['conditions_particulieres'] ?? '';
  $idClient = $_POST['id_client'] ?? null;
  $idProgramme = $_POST['id_programme'] ?? null;
  $idUtilisateur = $_POST['id_utilisateur'] ?? null;

  if ($numeroContrat && $dateSignature && $duree && $typeProduit && $quantitePrevue && $idClient && $idProgramme && $idUtilisateur) {
    $stmt = $conn->prepare("INSERT INTO contrat (numero_contrat, date_signature, duree, type_produit, quantite_prevue, statut, conditions_particulieres, id_client, id_programme, id_utilisateur) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssiii", $numeroContrat, $dateSignature, $duree, $typeProduit, $quantitePrevue, $statut, $conditionsParticulieres, $idClient, $idProgramme, $idUtilisateur);
    $stmt->execute();
    $stmt->close();
  }
}

// Récupération des contrats
$contrats = $conn->query("SELECT * FROM contrat ORDER BY date_signature DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>MegaScierie | Contrats</title>
  <link rel="stylesheet" href="style.css"><!-- Pour une feuille de style style.css externe -->
  <style>
    /* Exemple de styles, remplacez-les par ceux de votre projet */
    body { font-family: Arial, sans-serif; background: #ececec; }
    .main { max-width: 960px; margin: auto; background: #fff; padding: 2em; border-radius: 8px; box-shadow: 2px 2px 8px #bbb; }
    header h1 { margin-bottom: 1em; }
    .form-section { margin-bottom: 2em; }
    .form-section label { display: block; margin-top: 10px; }
    .form-section input, .form-section select, .form-section textarea { width: 100%; padding: 7px; margin-top: 3px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; }
    button { margin-top: 18px; background: #0a9e56; color: #fff; border: none; padding: 8px 14px; border-radius: 4px; cursor: pointer; }
    .table-section table { width: 100%; border-collapse: collapse; }
    .table-section th, .table-section td { border: 1px solid #c7c7c7; padding: 7px; text-align: left; }
    .table-section th { background: #f1f1f1; }
  </style>
</head>
<body>
  <section class="main">
    <header>
      <h1>📄 Saisie de contrat</h1>
    </header>

    <div class="form-section">
      <form method="POST" action="">
        <label>Numéro de contrat</label>
        <input type="text" name="numero_contrat" placeholder="Numéro du contrat" required>

        <label>Date de signature</label>
        <input type="date" name="date_signature" required>

        <label>Durée (en mois)</label>
        <input type="number" name="duree" min="1" required>

        <label>Type de produit</label>
        <input type="text" name="type_produit" placeholder="Type de produit" required>

        <label>Quantité prévue</label>
        <input type="number" name="quantite_prevue" step="0.01" placeholder="Quantité prévue" required>

        <label>Statut</label>
        <select name="statut" required>
          <option value="actif">Actif</option>
          <option value="terminé">Terminé</option>
        </select>

        <label>Conditions particulières</label>
        <textarea name="conditions_particulieres" rows="4" placeholder="Conditions particulières du contrat"></textarea>

        <label>ID Client</label>
        <input type="number" name="id_client" placeholder="ID du client" required>

        <label>ID Programme annuel</label>
        <input type="number" name="id_programme" placeholder="ID du programme annuel" required>

        <label>ID Utilisateur</label>
        <input type="number" name="id_utilisateur" placeholder="ID de l'utilisateur" required>

        <button type="submit">✅ Enregistrer le contrat</button>
      </form>
    </div>

    <div class="table-section">
      <h2>📋 Liste des contrats</h2>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Numéro</th>
            <th>Date signature</th>
            <th>Durée</th>
            <th>Type produit</th>
            <th>Quantité prévue</th>
            <th>Statut</th>
            <th>Conditions</th>
            <th>Client</th>
            <th>Programme</th>
            <th>Utilisateur</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = $contrats->fetch_assoc()) { ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['numero_contrat']) ?></td>
              <td><?= date("d/m/Y", strtotime($row['date_signature'])) ?></td>
              <td><?= htmlspecialchars($row['duree']) ?></td>
              <td><?= htmlspecialchars($row['type_produit']) ?></td>
              <td><?= number_format($row['quantite_prevue'], 2) ?></td>
              <td><?= htmlspecialchars($row['statut']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['conditions_particulieres'])) ?></td>
              <td><?= htmlspecialchars($row['id_client']) ?></td>
              <td><?= htmlspecialchars($row['id_programme']) ?></td>
              <td><?= htmlspecialchars($row['id_utilisateur']) ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </section>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>MegaScierie | Contrats</title>
</head>
<body>
  <section class="main">
    <header>
      <h1>📄 Saisie de contrat</h1>
    </header>

    <div class="form-section">
      <form method="POST" action="">
        <label>Numéro de contrat</label>
        <input type="text" name="numero_contrat" placeholder="Numéro du contrat" required>

        <label>Date de signature</label>
        <input type="date" name="date_signature" required>

        <label>Durée (en mois)</label>
        <input type="number" name="duree" min="1" required>

        <label>Type de produit</label>
        <input type="text" name="type_produit" placeholder="Type de produit" required>

        <label>Quantité prévue</label>
        <input type="number" name="quantite_prevue" step="0.01" placeholder="Quantité prévue" required>

        <label>Statut</label>
        <select name="statut" required>
          <option value="actif">Actif</option>
          <option value="terminé">Terminé</option>
        </select>

        <label>Conditions particulières</label>
        <textarea name="conditions_particulieres" rows="4" placeholder="Conditions particulières du contrat"></textarea>

        <label>ID Client</label>
        <input type="number" name="id_client" placeholder="ID du client" required>

        <label>ID Programme annuel</label>
        <input type="number" name="id_programme" placeholder="ID du programme annuel" required>

        <label>ID Utilisateur</label>
        <input type="number" name="id_utilisateur" placeholder="ID de l'utilisateur" required>

        <button type="submit">✅ Enregistrer le contrat</button>
      </form>
    </div>

    <div class="table-section">
      <h2>📋 Liste des contrats</h2>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Numéro</th>
            <th>Date signature</th>
            <th>Durée</th>
            <th>Type produit</th>
            <th>Quantité prévue</th>
            <th>Statut</th>
            <th>Conditions</th>
            <th>Client</th>
            <th>Programme</th>
            <th>Utilisateur</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = $contrats->fetch_assoc()) { ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['numero_contrat']) ?></td>
              <td><?= date("d/m/Y", strtotime($row['date_signature'])) ?></td>
              <td><?= htmlspecialchars($row['duree']) ?></td>
              <td><?= htmlspecialchars($row['type_produit']) ?></td>
              <td><?= number_format($row['quantite_prevue'], 2) ?></td>
              <td><?= htmlspecialchars($row['statut']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['conditions_particulieres'])) ?></td>
              <td><?= htmlspecialchars($row['id_client']) ?></td>
              <td><?= htmlspecialchars($row['id_programme']) ?></td>
              <td><?= htmlspecialchars($row['id_utilisateur']) ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </section>
</body>
</html>
