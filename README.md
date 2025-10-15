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
gestion-stocks-restaurant/
├── config.php # Configuration et constantes
├── connexion.php # Connexion à la base de données
├── index.php # Page d'accueil redirigeante
├── login.php # Page de connexion
├── inscription.php # Page d'inscription
├── profile.php # Profil utilisateur
├── logout.php # Déconnexion
├── admin/ # Panel d'administration
│ ├── admin.php # Liste des utilisateurs
│ ├── add_user.php # Ajout d'utilisateur
│ ├── edit_user.php # Modification d'utilisateur
│ └── delete_user.php # Suppression d'utilisateur
└── gestion_stocks_restaurant.sql # Structure de la BDD

text

## 🚀 Installation

1. **Cloner le repository**
   ```bash
   git clone https://github.com/votre-username/gestion-stocks-restaurant.git
Configurer la base de données

Importer le fichier gestion_stocks_restaurant.sql dans MySQL

Configurer les identifiants dans config.php

Configuration

php
// config.php
$db_host = 'localhost';
$db_name = '4625812_stocks';
$db_user = 'votre_utilisateur';
$db_pass = 'votre_mot_de_passe';
Accès à l'application

Accéder à index.php via votre serveur web

Compte administrateur par défaut : hijen@mail.fr / hijen

🔒 Sécurité
Protection CSRF (à implémenter)

Validation des entrées utilisateur

Gestion sécurisée des sessions

Prévention des injections SQL

Contrôle d'accès par permissions

👥 Rôles et permissions
Niveau	Permission	Accès
0	Utilisateur	Profil, déconnexion
1	Employé	+ Gestion stocks basique
2	Gestionnaire	+ Gestion utilisateurs limitée
3	Administrateur	Accès complet
📈 Développement futur
Interface de gestion des stocks

Système de commandes

Rapports et statistiques

API REST

Interface mobile

🤝 Contribution
Les contributions sont les bienvenues ! N'hésitez pas à :

Fork le projet

Créer une branche feature (git checkout -b feature/AmazingFeature)

Commit les changements (git commit -m 'Add AmazingFeature')

Push sur la branche (git push origin feature/AmazingFeature)

Ouvrir une Pull Request
