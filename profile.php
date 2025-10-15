<?php
session_start(); // ← Manquait ici pour accéder à $_SESSION

require 'config.php';
require 'connexion.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Facultatif : définir PERM_ADMIN si ce n'est pas déjà dans config.php
if (!defined('PERM_ADMIN')) {
    define('PERM_ADMIN', 3);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Profil utilisateur</h2>
    
    <div class="card">
        <div class="card-body">
            <p class="card-text"><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
            <p class="card-text"><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></p>
            <p class="card-text"><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p class="card-text"><strong>Niveau de permission :</strong> <?= $user['niveau_permission'] ?></p>
            <p class="card-text"><small class="text-muted">Membre depuis <?= $user['date_inscription'] ?></small></p>
            
            <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            <?php if ($user['niveau_permission'] >= PERM_ADMIN): ?>
                <a href="admin/" class="btn btn-primary">Administration</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
