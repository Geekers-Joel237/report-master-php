# ReportMaster

ReportMaster est une application de gestion de rapports hebdomadaires et d'objectifs de semaine pour XXX. 
Elle permet aux développeurs de soumettre et de suivre leurs tâches et objectifs, 
et aux RH/administration de surveiller l'ensemble de l'équipe.

## Table des matières

- [Introduction](#introduction)
- [Fonctionnalités](#fonctionnalités)
- [Technologies Utilisées](#technologies-utilisées)
- [Installation](#installation)
- [Configuration](#configuration)
- [Structure du Projet](#structure-du-projet)
- [Licence](#licence)

## Introduction

ReportMaster est conçu pour améliorer la gestion des tâches et des objectifs hebdomadaires chez XXX. 
Il fournit une interface intuitive pour les développeurs et les administrateurs pour gérer les rapports et 
les objectifs de manière efficace.
Ceci est la partie API 
## Fonctionnalités

- Gestion des projets
- Gestion des rapports hebdomadaires
- Suivi des objectifs de semaine 
- Gestion des rôles, des profils et permissions (RH/administration et développeurs)
- Rappels de rédaction des rapports (mail, discord, slack)
- Importation des rapports existants de Discord vers la plateforme
- Suivi des tâches et envoie automatique en fin de journée (ia ++ pour la redaction)
- Rappels / Changement de langue en fonction de la journée (Tous les mercredi)
- API REST
- Rappel des jours feries du calendrier (integration google calendar)
- Redaction automatique des rapports via l'ia,  l'idee est simple, tu selectionnes un projet, tu ajoutes progressivement ta liste de taches de la journee, ok pas ok
  puis en fin de journee un rapport est produit et envoye a ta place 

## Technologies Utilisées

- Backend: PHP 8.3, Laravel
- Gestion des dépendances : Composer
- Qualité du code : PHP_CodeSniffer
- Architecture: Hexagonale/Clean Architecture

## Installation

### Prérequis

- PHP 8.3
- Composer
- Node.js et npm
- Docker

### Étapes d'installation

1. Cloner le dépôt

```bash
git clone https://github.com/Geekers-Joel237/report-master-php.git
cd reportmaster
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
````

## Configuration
- ``$ composer lint app``

## Structure du Projet

## Licence
- Ce projet est sous licence MIT.
