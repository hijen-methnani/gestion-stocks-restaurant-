<?php
session_start();
require 'config.php';
require 'connexion.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage des entrées
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['mot_de_passe']);

    if (empty($email) || empty($password)) {
        $error = "Email et mot de passe requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide";
    } else {
        try {
            // Préparer et exécuter la requête
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Vérification du mot de passe haché
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                // Nettoyage des infos sensibles avant stockage en session (optionnel mais recommandé)
                unset($user['mot_de_passe']);

                $_SESSION['user'] = $user;
                header("Location: profile.php");
                exit;
            } else {
                $error = "Email ou mot de passe incorrect";
            }
        } catch (PDOException $e) {
            $error = "Erreur de connexion : " . $e->getMessage();
        }
    }
}
?>
