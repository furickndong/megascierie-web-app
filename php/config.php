<?php
$host = 'localhost';
$port = 8889;   // <-- port MySQL MAMP
$dbname = 'megascierie-web';
$username = 'root';
$password = 'root';  // Mot de passe root par défaut MAMP

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
