# 📚 Thoth – Learning Management System (LMS)

## 🧩 Description du projet

**Thoth** est une plateforme d’apprentissage en ligne (LMS) développée en **PHP natif**, reposant sur une **architecture MVC (Model–View–Controller)** claire, sécurisée et extensible.

Ce projet constitue un **socle technique backend** permettant :
- l’authentification sécurisée des étudiants,
- la gestion des cours,
- l’inscription des étudiants aux cours,
- la protection des routes via sessions PHP.

L’objectif principal est de démontrer une **bonne séparation des responsabilités**, un **routage centralisé**, et l’application des **bonnes pratiques de sécurité backend**.

---

## 🎯 Objectifs pédagogiques

À l’issue de ce projet, vous serez capable de :

- Comprendre et implémenter une architecture MVC
- Mettre en place un routage centralisé avec un point d’entrée unique
- Séparer clairement :
  - **Modèles** : logique métier & accès base de données
  - **Contrôleurs** : gestion des requêtes HTTP
  - **Vues** : rendu HTML/CSS
- Implémenter un système d’authentification sécurisé
- Protéger l’accès aux pages sensibles
- Comparer MVC à une approche procédurale classique

---

## 👤 Utilisateur du système

### Student (rôle unique)

Un étudiant peut :
- S’inscrire
- Se connecter / se déconnecter
- Accéder à son dashboard
- Consulter les cours disponibles
- S’inscrire à des cours
- Voir les cours auxquels il est inscrit

---

## ⚙️ Fonctionnalités principales

### 🔐 Authentification
- Inscription des étudiants
- Connexion / Déconnexion
- Validation des entrées (email, mot de passe)
- Hashage sécurisé des mots de passe (`password_hash`)
- Sessions PHP pour maintenir l’état connecté

### 📘 Gestion des cours
- Liste des cours disponibles
- Consultation des détails d’un cours
- Inscription à un cours
- Visualisation des cours suivis par l’étudiant

### 🔒 Sécurité & accès
- Routes protégées accessibles uniquement après connexion
- Redirection automatique vers `/login` si non authentifié
- Protection CSRF sur les formulaires sensibles
- Échappement des données contre les attaques XSS

---

## 🧭 Routes de l’application

### 🌍 Routes publiques
| URL | Description |
|---|---|
| `/` | Page d’accueil |
| `/register` | Inscription |
| `/login` | Connexion |

### 🔐 Routes protégées
| URL | Description |
|---|---|
| `/student/dashboard` | Dashboard étudiant |
| `/student/course/{id}` | Détails d’un cours |

> ⚠️ L’accès aux routes protégées nécessite une session active.

---


