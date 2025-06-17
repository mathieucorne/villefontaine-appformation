# Informations sur le projet

- nom : AppFormation - Mairie de Villefontaine
- description : Application interne de réservation de sessions de formations

# Prérequis
- VS Code
- PHP
- Composer

--- 

# Initialiser le projet

## Mise en place de l'environnement

## Installation des dépendances

- ORM Symfony
Un ORM (Object Relational Mapper) permet de transposer une architecture orienté objet à une base de données relationnelle comme MySQL ou PostgreSQL, ce qui facilite la maintenance d'une application.

Pour installer l'ORM Symfony :
composer require symfony/orm-pack

- Symfony Maker
Le bundle Symfony Maker permet de générer des entités ainsi que leurs controlleurs en nous évitant de devoir nous-même écrire le code en utilisant des commandes qui nous guident étape par étape pour le faire.

Pour installer Symfony Maker:
composer require --dev symfony/maker-bundle

## Utilisation du Symfony Maker pour modifier l'architecture de la base de données
Symfony suit une architecture MVC (Model, View, Controller). Le bundle Symfony Maker doit être installé au préalable.

### Créer une entité
Une entité ou le modèle représente le concept de la donnée à manipuler (Un utilisateur, une formation, une session).
Afin de créer une entité, il faut utiliser la commande :
php make:entity

[DOC - Créer une entité](https://symfony.com/doc/current/the-fast-track/en/8-doctrine.html#creating-entity-classes)

### Créer un controlleur
Un controlleur représente la classe chargée de manipuler la donnée en elle même pour les opérations de création, lecture, modification et suppression (CRUD).
php make:entity

[DOC - Créer un controller](https://symfony.com/doc/current/controller.html#a-basic-controller)

## API

### Outlook
[DOC - Créer un événement Outlook](https://learn.microsoft.com/fr-fr/graph/api/calendar-post-events?view=graph-rest-1.0&tabs=http#response)

[DOC - Créer une réunion](https://learn.microsoft.com/en-us/graph/api/application-post-onlinemeetings?view=graph-rest-1.0&tabs=http)


[DOC - Créer et envoyer un mail](https://learn.microsoft.com/fr-fr/graph/api/user-sendmail?view=graph-rest-1.0&tabs=http)

---

# Exécuter les outils de développement

## PHP
C:\Users\mathieu.corne\Desktop\php-8.4.8\php.exe

## Symfony
C:\Users\mathieu.corne\Desktop\symfony-cli\symfony.exe

---

# Résoudre les erreurs

## Erreurs de dépendances (DEP)

### DEP1

A l'installation du bundle Symfony Maker avec l'aide la commande "composer require --dev symfony/maker-bundle", l'erreur **DEP1** peut survenir, empêchant l'installation de certains éléments.

![Failed to download symfony/x from dist: The zip extension and unzip/7z commands are both missing, skipping.](C:/Users/mathieu.corne/Documents/doc_AppFormation/erreur_DEP1.png "Erreur DEP1")
