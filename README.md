# ReportMaster

ReportMaster est une application de gestion de rapports hebdomadaires et d'objectifs de semaine pour XXX. 
Elle permet aux développeurs de soumettre et de suivre leurs tâches et objectifs, 
et aux RH/administration de surveiller l'ensemble de l'équipe. L'idée est d'automatiser le process qui jusque-là 
est manuel, pas assez précis, ne permet pas d'avoir un historique clair.

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

- Gestion des projets : OK
- Gestion des rapports hebdomadaires : OK
- Suivi des objectifs de semaine : OK
- Gestion des rôles, des profils et permissions (RH/administration et développeurs) : A faire gestion des permissions
- Rappels de rédaction des rapports (mail, discord, slack) : A finaliser
- Importation des rapports existants de Discord vers la plateforme : Pertinent oui
- Telechargement rapports sur une periode precise en pdf : A finaliser
- Suivi des tâches et envoie automatique en fin de journée (ia ++ pour la redaction) : A faire
- Rappels / Changement de langue en fonction de la journée (Tous les mercredi) : A faire
- Generation rapports de fin de semaine(Génerer le rapport de fin de semaine sur la base du rapport journalier lun a ven) : A faire 
- API REST 
- Envoie des rapports sur Discord aussi coe avant en fait pour ne pas provoquer une rupture totale
- Historique clair de mes rapports : OK
- Responsive ++
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
- React / Ts / Tailwind Css / Redux

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
- generate swagger file
- ``vendor/bin/openai --format json --output ./public/swagger/swagger.json app``

## Structure du Projet

## Licence
- Ce projet est sous licence MIT.
