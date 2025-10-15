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

try {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = "Utilisateur introuvable";
        header("Location: index.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de base de données";
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $niveau = (int)$_POST['niveau_permission'];

    if (empty($nom) || empty($prenom) || empty($email)) {
        $_SESSION['error'] = "Tous les champs sont obligatoires";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Adresse email invalide";
    } elseif ($niveau < 0 || $niveau > 3) {
        $_SESSION['error'] = "Niveau de permission invalide";
    } else {
        try {
            if (!empty($_POST['mot_de_passe'])) {
                $mot_de_passe = password_hash(trim($_POST['mot_de_passe']), PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("UPDATE utilisateurs SET nom=?, prenom=?, email=?, mot_de_passe=?, niveau_permission=? WHERE id=?");
                $stmt->execute([$nom, $prenom, $email, $mot_de_passe, $niveau, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE utilisateurs SET nom=?, prenom=?, email=?, niveau_permission=? WHERE id=?");
                $stmt->execute([$nom, $prenom, $email, $niveau, $id]);
            }

            $_SESSION['success'] = "Utilisateur mis à jour avec succès";
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['error'] = "Cet email est déjà utilisé par un autre utilisateur";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Modifier l'utilisateur</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <form method="POST" class="border p-4 rounded">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($user['prenom']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="mot_de_passe" class="form-control" placeholder="Nouveau mot de passe">
        </div>
        <div class="mb-3">
            <label class="form-label">Niveau de permission</label>
            <select name="niveau_permission" class="form-select" required>
                <option value="0" <?= $user['niveau_permission'] == 0 ? 'selected' : '' ?>>0 - Utilisateur standard</option>
                <option value="1" <?= $user['niveau_permission'] == 1 ? 'selected' : '' ?>>1 - Employé</option>
                <option value="2" <?= $user['niveau_permission'] == 2 ? 'selected' : '' ?>>2 - Gestionnaire</option>
                <option value="3" <?= $user['niveau_permission'] == 3 ? 'selected' : '' ?>>3 - Administrateur</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</body>
</html>