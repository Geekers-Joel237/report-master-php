# ReportMaster

ReportMaster est une application de gestion de rapports hebdomadaires et d'objectifs de semaine pour Crina Studio. Elle permet aux développeurs de soumettre et de suivre leurs tâches et objectifs, et aux RH/administration de surveiller l'ensemble de l'équipe.

## Table des matières

- [Introduction](#introduction)
- [Fonctionnalités](#fonctionnalités)
- [Technologies Utilisées](#technologies-utilisées)
- [Installation](#installation)
- [Configuration](#configuration)
- [Structure du Projet](#structure-du-projet)
- [Licence](#licence)

## Introduction

ReportMaster est conçu pour améliorer la gestion des tâches et des objectifs hebdomadaires chez Crina Studio. Il fournit une interface intuitive pour les développeurs et les administrateurs pour gérer les rapports et les objectifs de manière efficace.
Ceci est la partie API 
## Fonctionnalités

- Gestion des rapports hebdomadaires
- Suivi des objectifs de semaine
- Gestion des rôles et des profils (RH/administration et développeurs)
- API REST 
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

### Étapes d'installation

1. Cloner le dépôt

```bash
git clone https://github.com/votre-utilisateur/reportmaster.git
cd reportmaster
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
````

## Configuration
- ``$ composer lint``

## Structure du Projet

## Licence
- Ce projet est sous licence MIT.
