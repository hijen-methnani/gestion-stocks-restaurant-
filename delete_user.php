<?php
require '../config.php';
require '../connexion.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['niveau_permission'] < PERM_ADMIN) {
    $_SESSION['error'] = "Accès non autorisé";
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID utilisateur invalide";
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Empêcher un administrateur de se supprimer lui-même
if ($id === $_SESSION['user']['id']) {
    $_SESSION['error'] = "Vous ne pouvez pas supprimer votre propre compte";
    header("Location: index.php");
    exit;
}

try {
    $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE id = ?");
    $check->execute([$id]);
    
    if ($check->rowCount() === 0) {
        $_SESSION['error'] = "Utilisateur introuvable";
    } else {
        // Supprimer l'utilisateur
        $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Utilisateur supprimé avec succès";
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors de la suppression: " . $e->getMessage();
}

header("Location: index.php");
exit;