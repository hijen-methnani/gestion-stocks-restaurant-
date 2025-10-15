<?php
session_start();

require '../config.php';
require '../connexion.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['user']['niveau_permission'] < PERM_ADMIN) {
    $_SESSION['error'] = "Accès non autorisé";
    header("Location: ../profile.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['mot_de_passe']);
    $niveau = isset($_POST['niveau_permission']) ? (int)$_POST['niveau_permission'] : -1;

    $errors = [];

    if (empty($nom)) $errors[] = "Le nom est obligatoire";
    if (empty($prenom)) $errors[] = "Le prénom est obligatoire";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
    if (strlen($password) < 8) $errors[] = "Le mot de passe doit faire 8 caractères minimum";
    if ($niveau < 0 || $niveau > 3) $errors[] = "Niveau de permission invalide";

    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, niveau_permission) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $hashed_password, $niveau]);

            $_SESSION['success'] = "Utilisateur ajouté avec succès";
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = "Cet email est déjà utilisé";
            } else {
                $errors[] = "Erreur lors de l'ajout : " . $e->getMessage();
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}
?>
