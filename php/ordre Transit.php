<?php
// Connexion à la base de données (MAMP par défaut)
$host = "localhost";
$dbname = "megascierie-web";
$user = "root";
$pass = "root"; // Par défaut sous MAMP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date_transit  = $_POST["date_transit"] ?? null;
    $type_transit  = $_POST["type_transit"] ?? null;
    $grume_id      = $_POST["grume_id"] ?: null;
    $debite_id     = $_POST["debite_id"] ?: null;
    $quantite      = $_POST["quantite"] ?? null;
    $destination   = $_POST["destination"] ?? null;
    $statut        = $_POST["statut"] ?? null;
    $conducteur    = $_POST["conducteur"] ?: null;
    $vehicule      = $_POST["vehicule"] ?: null;
    $observations  = $_POST["observations"] ?: null;

    // Insérer dans la base
    $sql = "INSERT INTO ORDRETRANSIT (
                date_transit, type_transit, grume_id, debite_id, quantite,
                destination, statut, conducteur, vehicule, observations
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $date_transit,
        $type_transit,
        $grume_id,
        $debite_id,
        $quantite,
        $destination,
        $statut,
        $conducteur,
        $vehicule,
        $observations
    ]);

    // Message succès ou redirection
    echo "<div style='background:#d4edda;padding:15px;border-radius:8px;color:#155724;margin:2rem;text-align:center'>
            ✅ Ordre de transit enregistré avec succès !<br>
            <a href='ordre_transit.html'>Retour</a>
          </div>";
}

// Optionnel : afficher la liste des derniers ordres (pour intégration dynamique dans ton dashboard)
$stmt = $pdo->query("SELECT * FROM ORDRETRANSIT ORDER BY id_transit DESC LIMIT 10");
$ordres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tu peux, si tu veux, générer le <tbody> HTML de la table, ex :
// foreach ($ordres as $ordre) { ... }

?>
