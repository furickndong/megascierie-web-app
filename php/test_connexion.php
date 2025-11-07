<?php
$host = 'localhost';
$port = 8889;
$dbname = 'megascierie-web';
$username = 'root';
$password = 'root';

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    echo "✅ Connexion réussie à la base de données !";
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}
?>
