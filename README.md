# gestion-stocks-restaurant-
# 🍽️ Système de Gestion de Stocks pour Restaurant

Une application web PHP complète pour la gestion des stocks et des utilisateurs dans un environnement de restaurant.

## 📋 Fonctionnalités

### 🔐 Gestion d'utilisateurs
- **Système d'authentification sécurisé** avec hachage de mots de passe
- **4 niveaux de permissions** :
  - 0 - Utilisateur standard
  - 1 - Employé
  - 2 - Gestionnaire
  - 3 - Administrateur
- **Inscription et connexion** sécurisées
- **Interface d'administration** complète

### 👨‍💼 Administration
- Ajout, modification et suppression d'utilisateurs
- Gestion des niveaux de permissions
- Protection contre l'auto-suppression
- Interface responsive avec Bootstrap

### 📦 Gestion des stocks (structure préparée)
- Tables prévues pour les catégories et produits
- Système de quantités
- Organisation par catégories

## 🛠️ Technologies utilisées

- **Backend** : PHP 7.4+
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3, Bootstrap 5.3
- **Sécurité** :
  - Protection contre les injections SQL (PDO)
  - Validation et sanitisation des entrées
  - Sessions sécurisées
  - Hachage BCrypt pour les mots de passe

## 📁 Structure du projet
