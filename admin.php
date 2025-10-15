<?php
session_start();

require '../config.php';
require '../connexion.php';

if (!defined('PERM_ADMIN')) {
    define('PERM_ADMIN', 3);
}

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['user']['niveau_permission'] < PERM_ADMIN) {
    $_SESSION['error'] = "Accès non autorisé";
    header("Location: ../profile.php");
    exit;
}

try {
    $stmt = $pdo->query("SELECT id, nom, prenom, email, niveau_permission FROM utilisateurs ORDER BY nom");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors de la récupération des utilisateurs";
    header("Location: ../profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h1 class="mb-4">Gestion des utilisateurs</h1>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="../profile.php" class="btn btn-secondary">Retour au profil</a>
        <a href="add_user.php" class="btn btn-success">Ajouter un utilisateur</a>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Permission</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['nom']) ?></td>
                <td><?= htmlspecialchars($user['prenom']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['niveau_permission'] ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                    <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
