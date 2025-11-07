<?php
session_start();
include('config.php');

$erreur = "";

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $utilisateur = trim($_POST['utilisateur']);
    $motdepasse = $_POST['motdepasse'];

    // Requête sur la table UTILISATEUR 
    $sql = "SELECT * FROM UTILISATEUR WHERE nom = ? AND statut = 'actif'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$utilisateur]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($motdepasse, $user['mot_de_passe'])) {
        // Enregistrer les infos en session
        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['telephone'] = $user['telephone'];
        $_SESSION['statut'] = $user['statut'];           
        $_SESSION['date_creation'] = $user['date_creation']; 
        $_SESSION['derniere_connexion'] = $user['derniere_connexion']; 

        // Mettre à jour la dernière connexion
        $update = $conn->prepare("UPDATE UTILISATEUR SET derniere_connexion = NOW() WHERE id_utilisateur = ?");
        $update->execute([$user['id_utilisateur']]);

        // Redirection vers le tableau de bord
        header("Location: tableau_de_bord.php");
        exit;
    } else {
        $erreur = "❌ Nom d’utilisateur ou mot de passe incorrect, ou compte inactif.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MegaScierie | Connexion</title>
<style>
  :root {
    --primary: #006d3b;
    --secondary: #00a86b;
    --light: #f5f8f6;
    --white: #fff;
    --dark: #222;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
  }

  .login-container {
    background: var(--white);
    padding: 2.5rem 3rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    width: 380px;
    text-align: center;
    position: relative;
  }

  .login-container h1 {
    color: var(--primary);
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
  }

  .login-container .logo {
    font-size: 2.5rem;
    margin-bottom: 1rem;
  }

  .form-group {
    text-align: left;
    margin-bottom: 1rem;
  }

  label {
    font-weight: 600;
    color: var(--dark);
    display: block;
    margin-bottom: 0.4rem;
  }

  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 0.7rem 0.9rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    transition: 0.3s;
  }

  input:focus {
    border-color: var(--secondary);
    outline: none;
    box-shadow: 0 0 4px rgba(0,168,107,0.3);
  }

  button {
    width: 100%;
    padding: 0.8rem;
    background: var(--primary);
    color: var(--white);
    font-size: 1rem;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
    font-weight: 600;
    margin-top: 0.5rem;
  }

  button:hover {
    background: var(--secondary);
    transform: translateY(-2px);
  }

  .footer {
    margin-top: 1.5rem;
    font-size: 0.9rem;
    color: #666;
  }

  .footer a {
    color: var(--secondary);
    text-decoration: none;
    font-weight: 500;
  }

  .footer a:hover {
    text-decoration: underline;
  }

  .error {
    color: red;
    margin-bottom: 10px;
  }
</style>
</head>
<body>

  <div class="login-container" id="loginContainer">
    <div class="logo">🪵</div>
    <h1>MegaScierie</h1>

    <?php if (!empty($erreur)): ?>
      <p class="error"><?= $erreur ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="utilisateur">Nom d’utilisateur</label>
        <input type="text" id="utilisateur" name="utilisateur" placeholder="Entrez votre nom d’utilisateur" required>
      </div>
      <div class="form-group">
        <label for="motdepasse">Mot de passe</label>
        <input type="password" id="motdepasse" name="motdepasse" placeholder="Entrez votre mot de passe" required>
      </div>
      <button type="submit" id="loginButton">Se connecter</button>
    </form>

    <div class="footer">
      <p>© 2025 MegaScierie. Tous droits réservés.</p>
    </div>
  </div>

</body>
</html>
