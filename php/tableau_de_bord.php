<?php
include('auth.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - MegaScierie</title>
</head>
<body>
    <h2>Bienvenue, <?= htmlspecialchars($_SESSION['nom']) ?> 👋</h2>
    <p>Rôle : <?= htmlspecialchars($_SESSION['role']) ?></p>

    <nav>
        <ul>
            <li><a href="saisie_grumes.php">Saisie de grumes</a></li>
            <li><a href="production.php">Production</a></li>
            <li><a href="facturation.php">Facturation</a></li>
            <li><a href="logout.php">Se déconnecter</a></li>
        </ul>
    </nav>
</body>
</html>
