<?php
// Connexion MAMP (base "megascierie", user root, mdp root)
$host = "localhost";
$dbname = "megascierie";
$user = "root";
$pass = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur connexion : " . $e->getMessage());
}

// Enregistrement si formulaire soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type_produit = $_POST["type_produit"] ?? null;
    $grume_id = $_POST["grume_id"] ?: null;
    $debite_id = $_POST["debite_id"] ?: null;
    $quantite = $_POST["quantite"] ?? null;
    $emplacement = $_POST["emplacement"] ?? null;
    $date_entree = $_POST["date_entree"] ?: null;
    $date_sortie = $_POST["date_sortie"] ?: null;
    $statut = $_POST["statut"] ?? 'en stock';

    // Insertion dans la table STOCK
    $sql = "INSERT INTO STOCK (
        type_produit, grume_id, debite_id, quantite,
        emplacement, date_entree, date_sortie, statut
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $type_produit,
        $grume_id,
        $debite_id,
        $quantite,
        $emplacement,
        $date_entree,
        $date_sortie,
        $statut
    ]);
    echo "<div style='background:#d4edda;padding:14px;border-radius:8px;color:#155724;margin:1.5rem;text-align:center'>
        ✅ Stock ajouté avec succès ! <a href='stock.html'>Retour formulaire</a>
    </div>";
}

// Récupération des stocks pour l’affichage dynamique (optionnel)
$stmt = $pdo->query("SELECT * FROM STOCK ORDER BY id_stock DESC LIMIT 20");
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Exemple : générer le tbody depuis PHP
echo "<div class='table-section'><h2>📋 Liste des stocks</h2><table><thead>
<tr>
<th>#</th>
<th>Type produit</th>
<th>ID grume</th>
<th>ID débité</th>
<th>Quantité</th>
<th>Emplacement</th>
<th>Date entrée</th>
<th>Date sortie</th>
<th>Statut</th>
<th>Historique</th>
</tr>
</thead><tbody>";
foreach ($stocks as $st) {
    // Historique fictif (tu peux améliorer en ajoutant une vraie colonne ou une logique).
    $historique = "";
    if ($st["date_entree"]) {
        $historique .= "Entré " . date("d/m", strtotime($st["date_entree"])) . " ";
    }
    if ($st["date_sortie"]) {
        $historique .= "• Sorti " . date("d/m", strtotime($st["date_sortie"]));
    }
    echo "<tr>
        <td>{$st['id_stock']}</td>
        <td>{$st['type_produit']}</td>
        <td>" . ($st['grume_id'] ?: '-') . "</td>
        <td>" . ($st['debite_id'] ?: '-') . "</td>
        <td>{$st['quantite']}</td>
        <td>{$st['emplacement']}</td>
        <td>{$st['date_entree']}</td>
        <td>{$st['date_sortie']}</td>
        <td>{$st['statut']}</td>
        <td>{$historique}</td>
    </tr>";
}
echo "</tbody></table></div>";
?>
