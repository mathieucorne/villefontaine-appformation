# AppFormation

## Informations sur le projet

- nom : AppFormation - Mairie de Villefontaine
- description : Application interne de réservation de sessions de formations

## Prérequis
- VS Code
- PHP
- Composer

--- 

## Initialiser le projet

### Mise en place de l'environnement

#### Installation des dépendances

- ORM Symfony
Un ORM (Object Relational Mapper) permet de transposer une architecture orienté objet à une base de données relationnelle comme MySQL ou PostgreSQL, ce qui facilite la maintenance d'une application.

Pour installer l'ORM Symfony :
composer require symfony/orm-pack

- Symfony Maker
Le bundle Symfony Maker permet de générer des entités ainsi que leurs controlleurs en nous évitant de devoir nous-même écrire le code en utilisant des commandes qui nous guident étape par étape pour le faire.

Pour installer Symfony Maker:
composer require --dev symfony/maker-bundle

#### Utilisation du Symfony Maker pour modifier l'architecture de la base de données
Symfony suit une architecture MVC (Model, View, Controller). Le bundle Symfony Maker doit être installé au préalable.

##### Créer une entité
Une entité ou le modèle représente le concept de la donnée à manipuler (Un utilisateur, une formation, une session).
Afin de créer une entité, il faut utiliser la commande :
php make:entity

[DOC - Créer une entité](https://symfony.com/doc/current/the-fast-track/en/8-doctrine.html#creating-entity-classes)

##### Créer un controlleur
Un controlleur représente la classe chargée de manipuler la donnée en elle même pour les opérations de création, lecture, modification et suppression (CRUD).
php make:entity

[DOC - Créer un controller](https://symfony.com/doc/current/controller.html#a-basic-controller)

### API

#### Outlook et Teams
[DOC - Créer un événement Outlook](https://learn.microsoft.com/fr-fr/graph/api/calendar-post-events?view=graph-rest-1.0&tabs=http#response)

[DOC - Créer une réunion](https://learn.microsoft.com/en-us/graph/api/application-post-onlinemeetings?view=graph-rest-1.0&tabs=http)


[DOC - Créer et envoyer un mail](https://learn.microsoft.com/fr-fr/graph/api/user-sendmail?view=graph-rest-1.0&tabs=http)

### FullCalendar

[DOC - Calendrier WebComponent](https://fullcalendar.io/docs/web-component)
[DOC - Calendrier à la semaine](https://fullcalendar.io/docs/business-hours)

---

## Exécuter les outils de développement

### PHP
C:\Users\mathieu.corne\Desktop\php-8.4.8\php.exe 

Installer PHP sur le [site officiel de PHP](https://windows.php.net/download/).

PHP doit être ajouté aux varibales d'environement.

### Composer 
Installer Composer sur [le site](https://getcomposer.org/download/)

### Symfony
C:\Users\mathieu.corne\Desktop\symfony-cli\symfony.exe

Installer Symfony sur [le site](https://symfony.com/doc/current/setup.html)

### XAMPP
Installer XAMPP depuis [Sourceforge](https://sourceforge.net/projects/xampp/)


---

## Modèle Logique de Données

utilisateurs (id, prenom, nom, email, password, type, id_service)
services (id, nom, email)
participations (id_utilisateur, id_session, date_inscription, type_inscription)
sessions (id, titre, heure_debut, heure_fin, nb_participants_max, statut_session, id_formation, id_salle)
salle (id, nom, batiment, nb_places_max)
formations (id, titre, description, imageURL, estVisible)
competences (id, nom)
utilisateurs_competences (id_utilisateur, id_competences)
formations_competences (id_formations, id_competences)
sessions_services (id_service, id_session)



---

## Résoudre les erreurs

### Erreurs de dépendances (DEP)

#### DEP1

A l'installation du bundle Symfony Maker avec l'aide la commande "composer require --dev symfony/maker-bundle", l'erreur **DEP1** peut survenir, empêchant l'installation de certains éléments.

![Failed to download symfony/x from dist: The zip extension and unzip/7z commands are both missing, skipping.](./doc_AppFormation/erreur_DEP/erreur_DEP1.png "Erreur DEP1")

#### DEP2

Au moment de créer la base de données via Doctrine (php bin/console doctrine:database:create), l'erreur DEP2 peut survenir, empêchant la création par Doctrine de cette même base de données.

Cette erreur est liée à une mauvaise configuration du fichier php.ini, plus précisément le PHP principal renseigné dans le PATH. 

**Pour résoudre l'erreur DEP2**, il faut décommenter les lignes `;extension=pdo_mysql` et `;extension=mysqli` en enlevant `;`.

![Could not create database `app` for connection named default An exception occurred in the driver: could not find driver](./doc_AppFormation/erreur_DEP/erreur_DEP2.png)

#### DEP3

Au moment de l'installation des dépendances Symfony ou d'autres dépendances PHP, en utilisant Composer, l'erreur DEP3 peut survenir, notamment via les commandes suivantes :
```
composer install
composer require x/x (ex: symfony/orm-pack)
```

![The openssl extension is required for SSL/TLS protection but is not available.](./doc_AppFormation/erreur_DEP/erreur_DEP3.png).

Cette erreur est liée à une mauvaise configuration du fichier php.ini, plus précisément le PHP principal renseigné dans le PATH.

**Pour résoudre l'erreur DEP3**, il faut décommenter la ligne `;extension=openssl` en enlevant le `;`.

#### DEP4

Au moment de la migration via Doctrine via la commande **php bin/console doctrine:migration:migrate**, l'erreur DEP4 peut survenir, en raison de la non création au préalable de la base de données renseignée dans le **fichier .env**. 

![An exception occured in the driver: SQLSTATE[YY000] [1049] Unknow database 'app'](./doc_AppFormation/erreur_DEP/erreur_DEP4.png)

> **Exemple de fichier .env**
> 
> ```DATABASE_URL="mysql://root@127.0.0.1:3306/app?serverVersion=10.5.8-MariaDB"```
> 
> La base de donnée renseignée est celle renseignée entre / et le ?, ici **app**. 

**Pour résoudre l'erreur DEP4**, il faut créer au préalable la base de donnée, ce qui peut se faire également via Doctrine avec la commande :
```php bin/console doctrine:database:create```


